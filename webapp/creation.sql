-----------------------------------------
--
-- Use this code to drop and create a schema.
-- In this case, the DROP TABLE statements can be removed.
--
-- DROP SCHEMA offtheshelf CASCADE;
-- CREATE SCHEMA offtheshelf;
-- SET search_path TO offtheshelf;
-----------------------------------------

-----------------------------------------
-- Drop old schema
-----------------------------------------

DROP SCHEMA IF EXISTS offtheshelf CASCADE;

CREATE SCHEMA offtheshelf;

DROP TABLE IF EXISTS offtheshelf.faq CASCADE;
DROP TABLE IF EXISTS offtheshelf.admins CASCADE;
DROP TABLE IF EXISTS offtheshelf.publisher CASCADE;
DROP TABLE IF EXISTS offtheshelf.author CASCADE;
DROP TABLE IF EXISTS offtheshelf.collections CASCADE;
DROP TABLE IF EXISTS offtheshelf.category CASCADE;
DROP TABLE IF EXISTS offtheshelf.users CASCADE;
DROP TABLE IF EXISTS offtheshelf.book CASCADE;
DROP TABLE IF EXISTS offtheshelf.wishlist CASCADE;
DROP TABLE IF EXISTS offtheshelf.cart CASCADE;
DROP TABLE IF EXISTS offtheshelf.purchase CASCADE;
DROP TABLE IF EXISTS offtheshelf.photo CASCADE;
DROP TABLE IF EXISTS offtheshelf.book_author CASCADE;
DROP TABLE IF EXISTS offtheshelf.book_collection CASCADE;
DROP TABLE IF EXISTS offtheshelf.review CASCADE;
DROP TABLE IF EXISTS offtheshelf.purchase_book CASCADE;
DROP TABLE IF EXISTS offtheshelf.delivery CASCADE;

DROP TYPE IF EXISTS offtheshelf.purchase_state CASCADE;

-----------------------------------------
-- Types
-----------------------------------------

CREATE TYPE offtheshelf.purchase_state AS ENUM ('Received', 'Dispatched', 'Delivered');

-----------------------------------------
-- Tables
-----------------------------------------

-- Note that some plural names were adopted because of reserved words in PostgreSQL.

CREATE TABLE offtheshelf.faq (
    question TEXT,
    answer TEXT,
    PRIMARY KEY (question, answer)
);

CREATE TABLE offtheshelf.admins (
    id_admin SERIAL PRIMARY KEY,
    admin_name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    admin_password TEXT NOT NULL
);

CREATE TABLE offtheshelf.publisher (
    id_publisher SERIAL PRIMARY KEY,
    publisher_name TEXT NOT NULL
);

CREATE TABLE offtheshelf.author (
    id_author SERIAL PRIMARY KEY,
    author_name TEXT NOT NULL
);

CREATE TABLE offtheshelf.collections (
    id_collection SERIAL PRIMARY KEY,
    collection_name TEXT NOT NULL
);

CREATE TABLE offtheshelf.category (
    id_category SERIAL PRIMARY KEY,
    category_name TEXT NOT NULL
);

CREATE TABLE offtheshelf.users (
    id_user SERIAL PRIMARY KEY,
    username TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,      
    user_password TEXT NOT NULL,                  
    user_address TEXT,
    phone CHAR(9),
    blocked BOOLEAN DEFAULT FALSE NOT NULL            
);

CREATE TABLE offtheshelf.book (
    id_book SERIAL PRIMARY KEY,
    title TEXT NOT NULL,      
    isbn NUMERIC NOT NULL UNIQUE,
    year INTEGER,  
    price NUMERIC(9, 2) NOT NULL CHECK (price >= 0),
    stock INTEGER NOT NULL CHECK (stock >= 0),           
    book_edition INTEGER,
    book_description TEXT,
    id_category INTEGER NOT NULL REFERENCES offtheshelf.category(id_category) ON UPDATE CASCADE ON DELETE CASCADE,
    id_publisher INTEGER REFERENCES offtheshelf.publisher(id_publisher) ON UPDATE CASCADE ON DELETE CASCADE                         
);

CREATE TABLE offtheshelf.wishlist (
    id_user INTEGER REFERENCES offtheshelf.users(id_user) ON DELETE CASCADE,
    id_book INTEGER REFERENCES offtheshelf.book(id_book) ON DELETE CASCADE,
    PRIMARY KEY (id_user, id_book)        
);

CREATE TABLE offtheshelf.cart (
    id_user INTEGER REFERENCES offtheshelf.users(id_user) ON DELETE CASCADE,
    id_book INTEGER REFERENCES offtheshelf.book(id_book) ON DELETE CASCADE,
    PRIMARY KEY (id_user, id_book)        
);

CREATE TABLE offtheshelf.purchase (
    id_purchase SERIAL PRIMARY KEY,
    purchase_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    id_user INTEGER NOT NULL REFERENCES offtheshelf.users(id_user) ON DELETE CASCADE,
    state_purchase offtheshelf.purchase_state NOT NULL
);

CREATE TABLE offtheshelf.photo (
    id_photo SERIAL PRIMARY KEY,
    photo_image TEXT NOT NULL,      
    id_book INTEGER REFERENCES offtheshelf.book(id_book) ON UPDATE CASCADE ON DELETE CASCADE,
    id_user INTEGER UNIQUE REFERENCES offtheshelf.users(id_user) ON UPDATE CASCADE ON DELETE CASCADE,
    id_admin INTEGER UNIQUE REFERENCES offtheshelf.admins(id_admin) ON UPDATE CASCADE ON DELETE CASCADE           
);

CREATE TABLE offtheshelf.book_author (
    id_book INTEGER REFERENCES offtheshelf.book(id_book) ON DELETE CASCADE,
    id_author INTEGER REFERENCES offtheshelf.author(id_author) ON DELETE CASCADE,
    PRIMARY KEY (id_book, id_author)                       
);

CREATE TABLE offtheshelf.book_collection (
    id_book INTEGER REFERENCES offtheshelf.book(id_book) ON DELETE CASCADE,
    id_collection INTEGER REFERENCES offtheshelf.collections(id_collection) ON DELETE CASCADE,
    PRIMARY KEY (id_book, id_collection)                 
);

CREATE TABLE offtheshelf.review (
    id_review SERIAL PRIMARY KEY,
    rating INTEGER NOT NULL CHECK (rating >= 0 AND rating <= 5),
    comment TEXT,
    review_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    id_book INTEGER NOT NULL REFERENCES offtheshelf.book(id_book) ON UPDATE CASCADE ON DELETE CASCADE,
    id_user INTEGER NOT NULL REFERENCES offtheshelf.users(id_user) ON UPDATE CASCADE ON DELETE CASCADE          
);

CREATE TABLE offtheshelf.purchase_book (
    id_purchase INTEGER REFERENCES offtheshelf.purchase(id_purchase) ON DELETE CASCADE,
    id_book INTEGER REFERENCES offtheshelf.book(id_book) ON DELETE CASCADE,
    PRIMARY KEY (id_purchase, id_book)        
);

CREATE TABLE offtheshelf.delivery (
    id_delivery SERIAL PRIMARY KEY,
    arrival TIMESTAMP WITH TIME ZONE NOT NULL,
    delivery_address TEXT NOT NULL,
    cost NUMERIC(9, 2) NOT NULL CHECK (cost >= 0),
    id_purchase INTEGER NOT NULL UNIQUE REFERENCES offtheshelf.purchase(id_purchase) ON UPDATE CASCADE ON DELETE CASCADE   
);

-----------------------------------------
-- INDEXES
-----------------------------------------

CREATE INDEX user_purchase ON offtheshelf.purchase USING hash (id_user);

CREATE INDEX book_category ON offtheshelf.book USING btree (id_category);
CLUSTER offtheshelf.book USING book_category;

CREATE INDEX book_review ON offtheshelf.review USING hash (id_book);

-- FTS INDEXES

-- Add column to book to store computed ts_vectors.
ALTER TABLE offtheshelf.book
ADD COLUMN tsvectors TSVECTOR;

-- Create a function to automatically update ts_vectors.
CREATE OR REPLACE FUNCTION book_search_update() RETURNS TRIGGER AS $$
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
 BEFORE INSERT OR UPDATE ON offtheshelf.book
 FOR EACH ROW
 EXECUTE PROCEDURE book_search_update();


-- Finally, create a GIN index for ts_vectors.
CREATE INDEX search_idx ON offtheshelf.book USING GIN (tsvectors);

-----------------------------------------
-- TRIGGERS and UDFs
-----------------------------------------

-- TRIGGER01
-- A book whose stock is non-positive cannot be purchased.

CREATE OR REPLACE FUNCTION book_available() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF EXISTS (SELECT * FROM offtheshelf.book WHERE id_book = NEW.id_book AND stock = 0) THEN
           RAISE EXCEPTION 'This book is out of stock.';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER book_available
        BEFORE INSERT ON offtheshelf.purchase_book
        FOR EACH ROW
        EXECUTE PROCEDURE book_available();

-- TRIGGER02
-- A book's stock decreases by 1 after a single purchase.

CREATE OR REPLACE FUNCTION book_purchased() RETURNS TRIGGER AS
$BODY$
BEGIN
        UPDATE offtheshelf.book
        SET stock = stock - 1
        WHERE "id_book" = NEW."id_book";
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER book_purchased
        AFTER INSERT ON offtheshelf.purchase_book
        EXECUTE PROCEDURE book_purchased();

-- TRIGGER03
-- A book is removed from an user's wishlist after the user adds it to the shopping cart.

CREATE OR REPLACE FUNCTION wishlist_to_cart() RETURNS TRIGGER AS
$BODY$
BEGIN
        DELETE FROM offtheshelf.wishlist
        WHERE "id_user" = NEW."id_user"
        AND "id_book" = NEW."id_book";
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER wishlist_to_cart 
        AFTER INSERT ON offtheshelf.cart
        EXECUTE PROCEDURE wishlist_to_cart();

-- TRIGGER04
-- A book is removed from an user's shopping cart after the user purchases it.

CREATE OR REPLACE FUNCTION cart_purchased() RETURNS TRIGGER AS
$BODY$
BEGIN
        DELETE FROM offtheshelf.cart
        WHERE "id_user" = NEW."id_user";
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER cart_purchased 
        AFTER INSERT ON offtheshelf.purchase
        EXECUTE PROCEDURE cart_purchased();

-- TRIGGER05
-- A blocked user can't submit reviews.

CREATE OR REPLACE FUNCTION blocked_review() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF EXISTS (SELECT * FROM offtheshelf.users WHERE id_user = NEW.id_user AND blocked = TRUE) THEN
           RAISE EXCEPTION 'Blocked users cannot submit reviews.';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER blocked_review
        BEFORE INSERT ON offtheshelf.review
        FOR EACH ROW
        EXECUTE PROCEDURE blocked_review();

-- TRIGGER06
-- A blocked user can't purchase books.

CREATE OR REPLACE FUNCTION blocked_purchase() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF EXISTS (SELECT * FROM offtheshelf.users WHERE id_user = NEW.id_user AND blocked = TRUE) THEN
           RAISE EXCEPTION 'Blocked users cannot purchase books.';
        END IF;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER blocked_purchase
        BEFORE INSERT ON offtheshelf.purchase
        FOR EACH ROW
        EXECUTE PROCEDURE blocked_purchase();

-----------------------------------------
-- end
-----------------------------------------
