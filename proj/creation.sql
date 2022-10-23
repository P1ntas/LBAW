-----------------------------------------
--
-- Use this code to drop and create a schema.
-- In this case, the DROP TABLE statements can be removed.
--
-- DROP SCHEMA lbaw2232 CASCADE;
-- CREATE SCHEMA lbaw2232;
-- SET search_path TO lbaw2232;
-----------------------------------------

-----------------------------------------
-- Drop old schema
-----------------------------------------

DROP TABLE IF EXISTS faq CASCADE;
DROP TABLE IF EXISTS admins CASCADE;
DROP TABLE IF EXISTS publisher CASCADE;
DROP TABLE IF EXISTS author CASCADE;
DROP TABLE IF EXISTS collections CASCADE;
DROP TABLE IF EXISTS category CASCADE;
DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS purchase CASCADE;
DROP TABLE IF EXISTS book CASCADE;
DROP TABLE IF EXISTS photo CASCADE;
DROP TABLE IF EXISTS book_author CASCADE;
DROP TABLE IF EXISTS book_collection CASCADE;
DROP TABLE IF EXISTS review CASCADE;
DROP TABLE IF EXISTS purchase_book CASCADE;
DROP TABLE IF EXISTS delivery CASCADE;
DROP TABLE IF EXISTS wishlist CASCADE;
DROP TABLE IF EXISTS cart CASCADE;

DROP TYPE IF EXISTS purchase_state;

-----------------------------------------
-- Types
-----------------------------------------

CREATE TYPE purchase_state AS ENUM ('Received', 'Dispatched', 'Delivered');

-----------------------------------------
-- Tables
-----------------------------------------

-- Note that some plural names were adopted because of reserved words in PostgreSQL.

CREATE TABLE faq (
    question TEXT,
    answer TEXT,
    PRIMARY KEY (question, answer)
);

CREATE TABLE admins (
    id_admin SERIAL PRIMARY KEY,
    admin_name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    admin_password TEXT NOT NULL
);

CREATE TABLE publisher (
    id_publisher SERIAL PRIMARY KEY,
    publisher_name TEXT NOT NULL
);

CREATE TABLE author (
    id_author SERIAL PRIMARY KEY,
    author_name TEXT NOT NULL
);

CREATE TABLE collections (
    id_collection SERIAL PRIMARY KEY,
    collection_name TEXT NOT NULL
);

CREATE TABLE category (
    id_category SERIAL PRIMARY KEY,
    category_name TEXT NOT NULL
);

CREATE TABLE users (
    id_user SERIAL PRIMARY KEY,
    username TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,      
    user_password TEXT NOT NULL,                  
    user_address TEXT,
    phone CHAR(9),
    blocked BOOLEAN DEFAULT FALSE NOT NULL            
);

CREATE TABLE purchase (
    id_purchase SERIAL PRIMARY KEY,
    purchase_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    id_user INTEGER NOT NULL REFERENCES users(id_user) ON DELETE CASCADE,
    TYPE purchase_state NOT NULL
);

CREATE TABLE book (
    id_book SERIAL PRIMARY KEY,
    title TEXT NOT NULL,      
    isbn INTEGER NOT NULL UNIQUE,
    year INTEGER,  
    price NUMERIC(9, 2) NOT NULL CHECK (price >= 0),
    stock INTEGER NOT NULL CHECK (stock >= 0),           
    book_edition INTEGER,
    book_description TEXT,
    id_category INTEGER NOT NULL REFERENCES category(id_category) ON UPDATE CASCADE ON DELETE CASCADE,
    id_publisher INTEGER REFERENCES publisher(id_publisher) ON UPDATE CASCADE ON DELETE CASCADE                         
);

CREATE TABLE photo (
    id_photo SERIAL PRIMARY KEY,
    photo_image TEXT NOT NULL,      
    id_book INTEGER REFERENCES book(id_book) ON UPDATE CASCADE ON DELETE CASCADE,
    id_user INTEGER UNIQUE REFERENCES users(id_user) ON UPDATE CASCADE ON DELETE CASCADE,
    id_admin INTEGER UNIQUE REFERENCES admins(id_admin) ON UPDATE CASCADE ON DELETE CASCADE           
);

CREATE TABLE book_author (
    id_book INTEGER REFERENCES book(id_book) ON DELETE CASCADE,
    id_author INTEGER REFERENCES author(id_author) ON DELETE CASCADE,
    PRIMARY KEY (id_book, id_author)                       
);

CREATE TABLE book_collection (
    id_book INTEGER REFERENCES book(id_book) ON DELETE CASCADE,
    id_collection INTEGER REFERENCES collections(id_collection) ON DELETE CASCADE,
    PRIMARY KEY (id_book, id_collection)                 
);

CREATE TABLE review (
    id_review SERIAL PRIMARY KEY,
    rating NUMERIC(1, 2) NOT NULL CHECK (rating >= 0 AND rating <= 5),
    comment TEXT,
    review_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    id_book INTEGER NOT NULL REFERENCES book(id_book) ON UPDATE CASCADE ON DELETE CASCADE,
    id_user INTEGER NOT NULL REFERENCES users(id_user) ON UPDATE CASCADE ON DELETE CASCADE          
);

CREATE TABLE purchase_book (
    id_purchase INTEGER REFERENCES purchase(id_purchase) ON DELETE CASCADE,
    id_book INTEGER REFERENCES book(id_book) ON DELETE CASCADE,
    PRIMARY KEY (id_purchase, id_book)        
);

CREATE TABLE delivery (
    id_delivery SERIAL PRIMARY KEY,
    arrival TIMESTAMP WITH TIME ZONE NOT NULL,
    delivery_address TEXT NOT NULL,
    cost NUMERIC(9, 2) NOT NULL CHECK (cost >= 0),
    id_purchase INTEGER NOT NULL UNIQUE REFERENCES purchase(id_purchase) ON UPDATE CASCADE ON DELETE CASCADE   
);

CREATE TABLE wishlist (
    id_user INTEGER REFERENCES users(id_user) ON DELETE CASCADE,
    id_book INTEGER REFERENCES book(id_book) ON DELETE CASCADE,
    PRIMARY KEY (id_user, id_book)        
);

CREATE TABLE cart (
    id_user INTEGER REFERENCES users(id_user) ON DELETE CASCADE,
    id_book INTEGER REFERENCES book(id_book) ON DELETE CASCADE,
    PRIMARY KEY (id_user, id_book)        
);

-----------------------------------------
-- INDEXES
-----------------------------------------

CREATE INDEX user_purchase ON purchase USING hash (id_user);

CREATE INDEX book_category ON book USING btree (id_category);
CLUSTER book USING book_category;

CREATE INDEX book_review ON review USING hash (id_book);

-- FTS INDEXES

-- Add column to book to store computed ts_vectors.
ALTER TABLE book
ADD COLUMN tsvectors TSVECTOR;

-- Create a function to automatically update ts_vectors.
CREATE FUNCTION book_search_update() RETURNS TRIGGER AS $$
BEGIN
 IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
         setweight(to_tsvector('english', NEW.title), 'A')
        );
 END IF;
 IF TG_OP = 'UPDATE' THEN
         IF (NEW.title <> OLD.title) THEN
           NEW.tsvectors = (
             setweight(to_tsvector('english', NEW.title), 'A')
           );
         END IF;
 END IF;
 RETURN NEW;
END $$
LANGUAGE plpgsql;

-- Create a trigger before insert or update on book.
CREATE TRIGGER book_search_update
 BEFORE INSERT OR UPDATE ON book
 FOR EACH ROW
 EXECUTE PROCEDURE book_search_update();


-- Finally, create a GIN index for ts_vectors.
CREATE INDEX search_idx ON work USING GIN (tsvectors);

-----------------------------------------
-- TRIGGERS and UDFs
-----------------------------------------

-- TRIGGER01
-- A book whose stock is non-positive cannot be purchased.

CREATE FUNCTION book_available() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF EXISTS (SELECT * FROM book WHERE id_book = NEW.id_book AND stock = 0) THEN
           RAISE EXCEPTION 'This book is out of stock.';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER book_available
        BEFORE INSERT ON purchase_book
        FOR EACH ROW
        EXECUTE PROCEDURE book_available();

-- TRIGGER02
-- A book's stock decreases by 1 after a single purchase.

CREATE FUNCTION book_purchased() RETURNS TRIGGER AS
$BODY$
BEGIN
        UPDATE book
        SET stock = stock - 1
        WHERE "id_book" = New."id_book"
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER book_purchased
        AFTER INSERT ON purchase_book
        EXECUTE PROCEDURE book_purchased();

-- TRIGGER03
-- A book is removed from an user's wishlist after the user adds it to the shopping cart.

CREATE FUNCTION wishlist_to_cart() RETURNS TRIGGER AS
$BODY$
BEGIN
        DELETE FROM wishlist
        WHERE "id_user" = New."id_user"
        AND "id_book" = New."id_book"
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER wishlist_to_cart 
        AFTER INSERT ON cart
        EXECUTE PROCEDURE wishlist_to_cart();

-- TRIGGER04
-- A book is removed from an user's shopping cart after the user purchases it.

CREATE FUNCTION cart_purchased() RETURNS TRIGGER AS
$BODY$
BEGIN
        DELETE FROM cart
        WHERE "id_user" = New."id_user"
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER cart_purchased 
        AFTER INSERT ON purchase
        EXECUTE PROCEDURE cart_purchased();

-- TRIGGER05
-- A blocked user can't submit reviews.

CREATE FUNCTION blocked_review() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF EXISTS (SELECT * FROM users WHERE id_user = NEW.id_user AND blocked = TRUE) THEN
           RAISE EXCEPTION 'Blocked users cannot submit reviews.';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER blocked_review
        BEFORE INSERT ON review
        FOR EACH ROW
        EXECUTE PROCEDURE blocked_review();

-- TRIGGER06
-- A blocked user can't purchase books.

CREATE FUNCTION blocked_purchase() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF EXISTS (SELECT * FROM users WHERE id_user = NEW.id_user AND blocked = TRUE) THEN
           RAISE EXCEPTION 'Blocked users cannot purchase books.';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER blocked_purchase
        BEFORE INSERT ON purchase
        FOR EACH ROW
        EXECUTE PROCEDURE blocked_purchase();

-----------------------------------------
-- end
-----------------------------------------
