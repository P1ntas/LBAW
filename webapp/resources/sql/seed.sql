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
SET search_path TO offtheshelf;

DROP TABLE IF EXISTS faq CASCADE;
DROP TABLE IF EXISTS admins CASCADE;
DROP TABLE IF EXISTS publisher CASCADE;
DROP TABLE IF EXISTS author CASCADE;
DROP TABLE IF EXISTS collections CASCADE;
DROP TABLE IF EXISTS category CASCADE;
DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS book CASCADE;
DROP TABLE IF EXISTS wishlist CASCADE;
DROP TABLE IF EXISTS cart CASCADE;
DROP TABLE IF EXISTS purchase CASCADE;
DROP TABLE IF EXISTS photo CASCADE;
DROP TABLE IF EXISTS book_author CASCADE;
DROP TABLE IF EXISTS book_collection CASCADE;
DROP TABLE IF EXISTS review CASCADE;
DROP TABLE IF EXISTS purchase_book CASCADE;
DROP TABLE IF EXISTS delivery CASCADE;

DROP TYPE IF EXISTS purchase_state CASCADE;

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
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL
);

CREATE TABLE publisher (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL
);

CREATE TABLE author (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL
);

CREATE TABLE collections (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL
);

CREATE TABLE category (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL
);

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,      
    password TEXT NOT NULL,                  
    user_address TEXT,
    phone CHAR(9),
    blocked BOOLEAN DEFAULT FALSE NOT NULL            
);

CREATE TABLE book (
    id SERIAL PRIMARY KEY,
    title TEXT NOT NULL,      
    isbn NUMERIC NOT NULL UNIQUE,
    year INTEGER,  
    price NUMERIC(9, 2) NOT NULL CHECK (price >= 0),
    stock INTEGER NOT NULL CHECK (stock >= 0),           
    book_edition INTEGER,
    book_description TEXT,
    category_id INTEGER NOT NULL REFERENCES category(id) ON UPDATE CASCADE ON DELETE CASCADE,
    publisher_id INTEGER REFERENCES publisher(id) ON UPDATE CASCADE ON DELETE CASCADE                         
);

CREATE TABLE wishlist (
    user_id INTEGER REFERENCES users(id) ON DELETE CASCADE,
    book_id INTEGER REFERENCES book(id) ON DELETE CASCADE,
    PRIMARY KEY (user_id, book_id)        
);

CREATE TABLE cart (
    user_id INTEGER REFERENCES users(id) ON DELETE CASCADE,
    book_id INTEGER REFERENCES book(id) ON DELETE CASCADE,
    PRIMARY KEY (user_id, book_id)        
);

CREATE TABLE purchase (
    id SERIAL PRIMARY KEY,
    purchase_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    state_purchase purchase_state NOT NULL
);

CREATE TABLE photo (
    id SERIAL PRIMARY KEY,
    photo_image TEXT NOT NULL,      
    book_id INTEGER REFERENCES book(id) ON UPDATE CASCADE ON DELETE CASCADE,
    user_id INTEGER UNIQUE REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,
    admin_id INTEGER UNIQUE REFERENCES admins(id) ON UPDATE CASCADE ON DELETE CASCADE           
);

CREATE TABLE book_author (
    book_id INTEGER REFERENCES book(id) ON DELETE CASCADE,
    author_id INTEGER REFERENCES author(id) ON DELETE CASCADE,
    PRIMARY KEY (book_id, author_id)                       
);

CREATE TABLE book_collection (
    book_id INTEGER REFERENCES book(id) ON DELETE CASCADE,
    collection_id INTEGER REFERENCES collections(id) ON DELETE CASCADE,
    PRIMARY KEY (book_id, collection_id)                 
);

CREATE TABLE review (
    id SERIAL PRIMARY KEY,
    rating INTEGER NOT NULL CHECK (rating >= 0 AND rating <= 5),
    comment TEXT,
    review_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    book_id INTEGER NOT NULL REFERENCES book(id) ON UPDATE CASCADE ON DELETE CASCADE,
    user_id INTEGER NOT NULL REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE          
);

CREATE TABLE purchase_book (
    purchase_id INTEGER REFERENCES purchase(id) ON DELETE CASCADE,
    book_id INTEGER REFERENCES book(id) ON DELETE CASCADE,
    PRIMARY KEY (purchase_id, book_id)        
);

CREATE TABLE delivery (
    id SERIAL PRIMARY KEY,
    arrival TIMESTAMP WITH TIME ZONE NOT NULL,
    delivery_address TEXT NOT NULL,
    cost NUMERIC(9, 2) NOT NULL CHECK (cost >= 0),
    purchase_id INTEGER NOT NULL UNIQUE REFERENCES purchase(id) ON UPDATE CASCADE ON DELETE CASCADE   
);

/*
Populate Tables
*/

INSERT INTO users VALUES (DEFAULT, 'Joana Lopes', 'joanalopes@gmail.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', '696 Magna. Street', '935235731', DEFAULT);

INSERT INTO category VALUES (DEFAULT,'Fantasy');
INSERT INTO category VALUES (DEFAULT,'History');
INSERT INTO category VALUES (DEFAULT,'Comedy');

INSERT INTO publisher VALUES (DEFAULT, 'ASA');
INSERT INTO publisher VALUES (DEFAULT, 'LEIA');
INSERT INTO publisher VALUES (DEFAULT, 'PortoEditora');

INSERT INTO book VALUES (DEFAULT, 'Lord of The Rings', 5351034105, 1918, '9.99', 5, 5, 'est, congue a, aliquet vel, vulputate eu, odio. Phasellus at augue id ante dictum cursus. Nunc mauris elit, dictum eu, eleifend nec, malesuada ut, sem. Nulla interdum. Curabitur dictum. Phasellus in felis. Nulla tempor augue ac ipsum. Phasellus vitae mauris sit amet lorem semper auctor.', 1, 1);
INSERT INTO book VALUES (DEFAULT, 'The Human History', 4733319526, 1970, '7.99', 29, 6, 'commodo auctor velit. Aliquam nisl. Nulla eu neque pellentesque massa lobortis ultrices. Vivamus rhoncus. Donec est. Nunc ullamcorper, velit in aliquet lobortis, nisi nibh lacinia orci, consectetuer euismod est arcu ac orci. Ut semper pretium neque. Morbi quis urna. Nunc quis arcu vel quam dignissim pharetra. Nam ac nulla. In tincidunt congue turpis. In condimentum. Donec at', 2, 2);

INSERT INTO author VALUES (DEFAULT, 'Jose Saramago');
INSERT INTO author VALUES (DEFAULT, 'J K Rowling');

INSERT INTO book_author VALUES (1, 1);
INSERT INTO book_author VALUES (1, 2);
INSERT INTO book_author VALUES (2, 2);

--INSERT INTO purchase VALUES (DEFAULT, '2022-07-13 14:03:42 +9:00', 1, 'Received');
--INSERT INTO purchase VALUES (DEFAULT, '2022-01-30 09:05:56 +8:00', 1, 'Dispatched');
--INSERT INTO purchase VALUES (DEFAULT, '2021-12-22 22:21:03 -4:00', 1, 'Delivered');
--
--INSERT INTO purchase_book VALUES (1, 1);
--INSERT INTO purchase_book VALUES (2, 2);
--INSERT INTO purchase_book VALUES (3, 1);
--
--INSERT INTO delivery VALUES (DEFAULT, '2023-05-18 03:50:35  +0:00', '335-2063 Ligula. St.', '131.96', 1);
--INSERT INTO delivery VALUES (DEFAULT, '2023-09-09 10:14:51  +4:00', '596-213 In St.', '104.86', 2);
--INSERT INTO delivery VALUES (DEFAULT, '2023-06-28 03:00:56  +9:00', '432-7822 Parturient Av.', '104.80', 3);

INSERT INTO cart VALUES (1, 1);
INSERT INTO cart VALUES (1, 2);

-----------------------------------------
-- INDEXES
-----------------------------------------

CREATE INDEX user_purchase ON purchase USING hash (user_id);

CREATE INDEX book_category ON book USING btree (category_id);
CLUSTER book USING book_category;

CREATE INDEX book_review ON review USING hash (book_id);

-- FTS INDEXES

-- Add column to book to store computed ts_vectors.
ALTER TABLE book
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
 BEFORE INSERT OR UPDATE ON book
 FOR EACH ROW
 EXECUTE PROCEDURE book_search_update();


-- Finally, create a GIN index for ts_vectors.
CREATE INDEX search_idx ON book USING GIN (tsvectors);

-----------------------------------------
-- TRIGGERS and UDFs
-----------------------------------------

-- TRIGGER01
-- A book whose stock is non-positive cannot be purchased.

CREATE OR REPLACE FUNCTION book_available() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF EXISTS (SELECT * FROM book WHERE id = NEW.book_id AND stock = 0) THEN
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

CREATE OR REPLACE FUNCTION book_purchased() RETURNS TRIGGER AS
$BODY$
BEGIN
        UPDATE book
        SET stock = stock - 1
        WHERE id = NEW.book_id;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER book_purchased
        AFTER INSERT ON purchase_book
        EXECUTE PROCEDURE book_purchased();

-- TRIGGER03
-- A book is removed from an user's wishlist after the user adds it to the shopping cart.

CREATE OR REPLACE FUNCTION wishlist_to_cart() RETURNS TRIGGER AS
$BODY$
BEGIN
        DELETE FROM wishlist
        WHERE user_id = NEW.user_id
        AND book_id = NEW.book_id;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER wishlist_to_cart 
        AFTER INSERT ON cart
        EXECUTE PROCEDURE wishlist_to_cart();

-- TRIGGER04
-- A book is removed from an user's shopping cart after the user purchases it.

CREATE OR REPLACE FUNCTION cart_purchased() RETURNS TRIGGER AS
$BODY$
BEGIN
        DELETE FROM cart
        WHERE user_id = NEW.user_id;
        RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER cart_purchased 
        AFTER INSERT ON purchase
        EXECUTE PROCEDURE cart_purchased();

-- TRIGGER05
-- A blocked user can't submit reviews.

CREATE OR REPLACE FUNCTION blocked_review() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF EXISTS (SELECT * FROM users WHERE id = NEW.id AND blocked = TRUE) THEN
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

CREATE OR REPLACE FUNCTION blocked_purchase() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF EXISTS (SELECT * FROM users WHERE id = NEW.id AND blocked = TRUE) THEN
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
