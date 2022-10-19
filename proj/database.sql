PRAGMA foreign_keys = ON;
.mode columns
.headers on
.nullvalue NULL
BEGIN TRANSACTION;

-----------------------------------------
-- Types
-----------------------------------------

CREATE TYPE purchase_state AS ENUM ('Received', 'Dispatched', 'Delivered');

-----------------------------------------
-- Tables
-----------------------------------------

-- Note that some plural names were adopted because of reserved words in PostgreSQL.

-- Table: faq
DROP TABLE IF EXISTS faq;

CREATE TABLE faq (
    question TEXT,
    answer TEXT,
    PRIMARY KEY (question, answer)
);

-- Table: admins
DROP TABLE IF EXISTS admins;

CREATE TABLE admins (
    id_admin SERIAL PRIMARY KEY,
    admin_name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    admin_password TEXT NOT NULL
);

-- Table: publisher
DROP TABLE IF EXISTS publisher;

CREATE TABLE publisher (
    id_publisher SERIAL PRIMARY KEY,
    publisher_name TEXT NOT NULL
);

-- Table: author
DROP TABLE IF EXISTS author;

CREATE TABLE author (
    id_author SERIAL PRIMARY KEY,
    author_name TEXT NOT NULL
);

-- Table: collections
DROP TABLE IF EXISTS collections;

CREATE TABLE collections (
    id_collection SERIAL PRIMARY KEY,
    collection_name TEXT NOT NULL
);

-- Table: category
DROP TABLE IF EXISTS category;

CREATE TABLE category (
    id_category SERIAL PRIMARY KEY,
    category_name TEXT NOT NULL
);

-- Table: users
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id_user SERIAL PRIMARY KEY,
    username TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,      
    user_password TEXT NOT NULL,                  
    user_address TEXT,
    phone CHAR(9),
    blocked BOOLEAN DEFAULT FALSE NOT NULL            
);

-- Table: purchase
DROP TABLE IF EXISTS purchase;

CREATE TABLE purchase (
    id_purchase SERIAL PRIMARY KEY,
    purchase_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    id_user INTEGER NOT NULL REFERENCES users(id_user) ON DELETE CASCADE,
    TYPE purchase_state NOT NULL
);

-- Table: book
DROP TABLE IF EXISTS book;

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

-- Table: photo
DROP TABLE IF EXISTS photo;

CREATE TABLE photo (
    id_photo SERIAL PRIMARY KEY,
    photo_image TEXT NOT NULL,      
    id_book INTEGER REFERENCES book(id_book) ON UPDATE CASCADE ON DELETE CASCADE,
    id_user INTEGER UNIQUE REFERENCES users(id_user) ON UPDATE CASCADE ON DELETE CASCADE,
    id_admin INTEGER UNIQUE REFERENCES admins(id_admin) ON UPDATE CASCADE ON DELETE CASCADE           
);

-- Table: book_author
DROP TABLE IF EXISTS book_author;

CREATE TABLE book_author (
    id_book INTEGER REFERENCES book(id_book) ON DELETE CASCADE,
    id_author INTEGER REFERENCES author(id_author) ON DELETE CASCADE,
    PRIMARY KEY (id_book, id_author)                       
);

-- Table: book_collection
DROP TABLE IF EXISTS book_collection;

CREATE TABLE book_collection (
    id_book INTEGER REFERENCES book(id_book) ON DELETE CASCADE,
    id_collection INTEGER REFERENCES collections(id_collection) ON DELETE CASCADE,
    PRIMARY KEY (id_book, id_collection)                 
);

-- Table: review
DROP TABLE IF EXISTS review;

CREATE TABLE review (
    id_review SERIAL PRIMARY KEY,
    rating NUMERIC(1, 2) NOT NULL CHECK (rating >= 0 AND rating <= 5),
    comment TEXT,
    review_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    id_book INTEGER NOT NULL REFERENCES book(id_book) ON UPDATE CASCADE ON DELETE CASCADE,
    id_user INTEGER NOT NULL REFERENCES users(id_user) ON UPDATE CASCADE ON DELETE CASCADE          
);

-- Table: purchase_book
DROP TABLE IF EXISTS purchase_book;

CREATE TABLE purchase_book (
    id_purchase INTEGER REFERENCES purchase(id_purchase) ON DELETE CASCADE,
    id_book INTEGER REFERENCES book(id_book) ON DELETE CASCADE,
    PRIMARY KEY (id_purchase, id_book)        
);

-- Table: delivery
DROP TABLE IF EXISTS delivery;

CREATE TABLE delivery (
    id_delivery SERIAL PRIMARY KEY,
    arrival TIMESTAMP WITH TIME ZONE NOT NULL,
    delivery_address TEXT NOT NULL,
    cost NUMERIC(9, 2) NOT NULL CHECK (cost >= 0),
    id_purchase INTEGER NOT NULL UNIQUE REFERENCES purchase(id_purchase) ON UPDATE CASCADE ON DELETE CASCADE   
);

-- Table: wishlist
DROP TABLE IF EXISTS wishlist;

CREATE TABLE wishlist (
    id_user INTEGER REFERENCES users(id_user) ON DELETE CASCADE,
    id_book INTEGER REFERENCES book(id_book) ON DELETE CASCADE,
    PRIMARY KEY (id_user, id_book)        
);

-- Table: cart
DROP TABLE IF EXISTS cart;

CREATE TABLE cart (
    id_user INTEGER REFERENCES users(id_user) ON DELETE CASCADE,
    id_book INTEGER REFERENCES book(id_book) ON DELETE CASCADE,
    PRIMARY KEY (id_user, id_book)        
);

COMMIT TRANSACTION;
PRAGMA foreign_keys = on;
