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
DROP TABLE IF EXISTS notifications CASCADE;
DROP TABLE IF EXISTS password_resets CASCADE;

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

CREATE TABLE publisher (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL UNIQUE
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
    name TEXT NOT NULL UNIQUE
);

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,      
    password TEXT NOT NULL,                  
    user_address TEXT,
    phone CHAR(9),
    blocked BOOLEAN DEFAULT FALSE NOT NULL,
    admin_perms BOOLEAN DEFAULT FALSE NOT NULL,
    remember_token VARCHAR    
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
    user_id INTEGER UNIQUE REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE      
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

CREATE TABLE notifications (
    id SERIAL PRIMARY KEY,
    content TEXT NOT NULL,
    user_id INTEGER NOT NULL REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE   
);

CREATE TABLE password_resets (
    email VARCHAR(255) PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL
);

/*
Populate Tables
*/

-- password for all users: 123456
INSERT INTO users VALUES (DEFAULT, 'Afonso Abreu', 'afonsoabreu@gmail.com', '$2y$10$BoAsL2bmrH4A4VScQ14nCOHu1A8DgYgOSMFkCMvQIJlw2cZWUTR0u', '696 Magna. Street', '935235731', DEFAULT, DEFAULT);
INSERT INTO users VALUES (DEFAULT, 'Afonso Pinto', 'afonsopinto@gmail.com', '$2y$10$BoAsL2bmrH4A4VScQ14nCOHu1A8DgYgOSMFkCMvQIJlw2cZWUTR0u', '696 Magna. Street', '935235731', DEFAULT, DEFAULT);
INSERT INTO users VALUES (DEFAULT, 'Ruben Monteiro', 'rubenmonteiro@gmail.com', '$2y$10$BoAsL2bmrH4A4VScQ14nCOHu1A8DgYgOSMFkCMvQIJlw2cZWUTR0u', '696 Magna. Street', '935235731', DEFAULT, DEFAULT);
INSERT INTO users VALUES (DEFAULT, 'Diogo Silva', 'diogosilva@gmail.com', '$2y$10$BoAsL2bmrH4A4VScQ14nCOHu1A8DgYgOSMFkCMvQIJlw2cZWUTR0u', '696 Magna. Street', '987654321', DEFAULT, TRUE);
-- last one is admin

INSERT INTO faq VALUES ('This is a question', 'This is an answer');
INSERT INTO faq VALUES ('What do I do if I cant find a book I want?', 'Try to search better \_/(O-O)\_/');

INSERT INTO category VALUES (DEFAULT, 'Fantasy');
INSERT INTO category VALUES (DEFAULT, 'History');
INSERT INTO category VALUES (DEFAULT, 'Comedy');
INSERT INTO category VALUES (DEFAULT, 'Sports');
INSERT INTO category VALUES (DEFAULT, 'Adventure');

INSERT INTO publisher VALUES (DEFAULT, 'ASA');
INSERT INTO publisher VALUES (DEFAULT, 'LEIA');
INSERT INTO publisher VALUES (DEFAULT, 'PortoEditora');

INSERT INTO book VALUES (DEFAULT, 'Lord Of The Rings', 5351034105, 2000, '9.99', 5, 3, 'An iconic story.', 1, 1);
INSERT INTO book VALUES (DEFAULT, 'The Human History', 4733319526, 2009, '7.99', 29, 1, 'An educational book about the history of our species', 2, 2);
INSERT INTO book VALUES (DEFAULT, 'Da Vinci Code', 5351034169, 2009, '10.99', 7, 1, 'An amazing adventure.', 5, 3);
INSERT INTO book VALUES (DEFAULT, 'Football Rules', 5351034333, 2009, '6.99', 7, 1, 'The rules of the biggest sport in the world.', 4, 3);

INSERT INTO author VALUES (DEFAULT, 'Jose Saramago');
INSERT INTO author VALUES (DEFAULT, 'J K Rowling');
INSERT INTO author VALUES (DEFAULT, 'André Telhado');
INSERT INTO author VALUES (DEFAULT, 'Liam Tyson');

INSERT INTO book_author VALUES (1, 4);
INSERT INTO book_author VALUES (2, 2);
INSERT INTO book_author VALUES (2, 3);
INSERT INTO book_author VALUES (3, 1);
INSERT INTO book_author VALUES (4, 3);

INSERT INTO review VALUES (DEFAULT, 4, 'What a pleasent experience.', '2022-10-18 03:50:35  +0:00', 1, 1);
INSERT INTO review VALUES (DEFAULT, 5, 'Very interesting.', '2022-10-18 03:50:35  +0:00', 2, 2);
INSERT INTO review VALUES (DEFAULT, 3, 'Somewhat funny.', '2022-10-18 03:50:35  +0:00', 3, 3);

INSERT INTO cart VALUES (1, 1);
INSERT INTO cart VALUES (1, 2);
INSERT INTO cart VALUES (2, 3);
INSERT INTO cart VALUES (2, 4);
INSERT INTO cart VALUES (3, 2);
INSERT INTO cart VALUES (3, 3);

INSERT INTO purchase VALUES (DEFAULT, '2022-07-13 14:03:42 +9:00', 1, 'Received');
INSERT INTO purchase VALUES (DEFAULT, '2022-01-30 09:05:56 +8:00', 2, 'Dispatched');
INSERT INTO purchase VALUES (DEFAULT, '2021-12-22 22:21:03 -4:00', 3, 'Delivered');

INSERT INTO purchase_book VALUES (1, 1);
INSERT INTO purchase_book VALUES (2, 2);
INSERT INTO purchase_book VALUES (3, 3);

INSERT INTO delivery VALUES (DEFAULT, '2022-10-18 03:50:35  +0:00', '335-2063 Ligula. St.', '131.96', 1);
INSERT INTO delivery VALUES (DEFAULT, '2022-10-09 10:14:51  +4:00', '596-213 In St.', '104.86', 2);
INSERT INTO delivery VALUES (DEFAULT, '2022-10-28 03:00:56  +9:00', '432-7822 Parturient Av.', '104.80', 3);

INSERT INTO wishlist VALUES (1, 1);
INSERT INTO wishlist VALUES (1, 4);
INSERT INTO wishlist VALUES (2, 1);
INSERT INTO wishlist VALUES (3, 2);
INSERT INTO wishlist VALUES (3, 3);

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
        BEFORE INSERT ON cart
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
        FOR EACH ROW
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
        FOR EACH ROW
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
        FOR EACH ROW
        EXECUTE PROCEDURE cart_purchased();

-- TRIGGER05
-- A blocked user can't submit reviews.

CREATE OR REPLACE FUNCTION blocked_review() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF EXISTS (SELECT * FROM users WHERE id = NEW.user_id AND blocked = TRUE) THEN
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
        IF EXISTS (SELECT * FROM users WHERE id = NEW.user_id AND blocked = TRUE) THEN
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
