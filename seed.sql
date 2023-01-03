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
    admin_perms BOOLEAN DEFAULT FALSE NOT NULL     
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

/*
Populate Tables
*/

-- password for all users: 1234
INSERT INTO users VALUES (DEFAULT, 'Afonso Abreu', 'afonsoabreu@gmail.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', '696 Magna. Street', '935235731', DEFAULT, DEFAULT);
INSERT INTO users VALUES (DEFAULT, 'Afonso Pinto', 'afonsopinto@gmail.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', '696 Magna. Street', '935235731', DEFAULT, DEFAULT);
INSERT INTO users VALUES (DEFAULT, 'Ruben Monteiro', 'rubenmonteiro@gmail.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', '696 Magna. Street', '935235731', DEFAULT, DEFAULT);
INSERT INTO users VALUES (DEFAULT, 'Diogo Silva', 'diogosilva@gmail.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', '696 Magna. Street', '987654321', DEFAULT, TRUE);
-- last one is admin

INSERT INTO category VALUES (DEFAULT, 'Fantasy');
INSERT INTO category VALUES (DEFAULT, 'History');
INSERT INTO category VALUES (DEFAULT, 'Comedy');
INSERT INTO category VALUES (DEFAULT, 'Sports');
INSERT INTO category VALUES (DEFAULT, 'Adventure');
INSERT INTO category VALUES (DEFAULT, 'Drama');
INSERT INTO category VALUES (DEFAULT, 'Romance');
INSERT INTO category VALUES (DEFAULT, 'Horror');
INSERT INTO category VALUES (DEFAULT, 'Sci-fi');
INSERT INTO category VALUES (DEFAULT, 'Thriller');

INSERT INTO publisher VALUES (DEFAULT, 'ASA');
INSERT INTO publisher VALUES (DEFAULT, 'LEIA');
INSERT INTO publisher VALUES (DEFAULT, 'PortoEditora');

INSERT INTO book (title, isbn, year, price, stock, book_edition, book_description) VALUES 
  (DEFAULT, 'The Catcher in the Rye', '0316769487', 1951, 10.99, 100, 1, 'The story of Holden Caulfield, a young man struggling with depression and alienation.', 6, 1),
  (DEFAULT, 'To Kill a Mockingbird', '0061120081', 1960, 11.99, 50, 2, 'The story of a young girl, Scout, growing up in the Deep South during the 1930s and the racial injustice she witnesses.', 6, 2), 
  (DEFAULT, 'Pride and Prejudice', '0141439580', 1813, 8.99, 75, 3, 'The story of the Bennett family and their search for love and marriage in early 19th century England.', 7, 3),
  (DEFAULT, 'The Great Gatsby', '0743273567', 1925, 9.99, 90, 4, 'The story of the wealthy young man, Jay Gatsby, and his tumultuous relationships in the summer of 1922.', 6, 1),
  (DEFAULT, 'The Alchemist', '0061122416', 1988, 12.99, 40, 5, 'The story of Santiago, a shepherd boy who embarks on a journey to find his personal legend.', 5, 2),
  (DEFAULT, 'One Hundred Years of Solitude', '0060531045', 1967, 14.99, 30, 6, 'The epic story of the Buendía family and their experiences in the Colombian town of Macondo.', 5, 3),
  (DEFAULT, 'Moby-Dick', '0451524934', 1851, 16.99, 20, 7, 'The tale of Captain Ahabs obsession with hunting the white whale, Moby Dick.'), 5,
  (DEFAULT, 'The Picture of Dorian Gray', '0486457150', 1890, 8.99, 60, 8, 'The story of Dorian Gray, a young man who remains young and handsome while his portrait ages.', 2, 1),
  (DEFAULT, 'The Bell Jar', '0060837053', 1963, 11.99, 50, 9, 'The semi-autobiographical story of Esther Greenwood, a young woman struggling with mental illness.', 6, 2),
  (DEFAULT, 'The Grapes of Wrath', '0140177396', 1939, 12.99, 40, 10, 'The story of the Joad family and their journey to California during the Great Depression.'), 2, 3),
  (DEFAULT, 'The Brothers Karamazov', '0679642701', 1880, 14.99, 30, 11, 'The story of the Karamazov brothers and their complex relationships with each other and their father.', 2, 1),
  (DEFAULT, 'The Old Man and the Sea', '0684801221', 1952, 9.99, 70, 12, 'The story of Santiago, an aging Cuban fisherman, and his struggle with a giant marlin.', 5, 2),
  (DEFAULT, 'Jane Eyre', '0451526341', 1847, 13.99, 35, 34, 'The story of Jane Eyre, a young woman who struggles with her identity and independence as she navigates life as a governess.', 2, 3),
  (DEFAULT, 'Brave New World', '0060929871', 1932, 12.99, 40, 35, 'A dystopian novel set in a future society where people are genetically engineered and live in a highly controlled, pleasure-seeking society.', 1, 1),
  (DEFAULT, 'The Color Purple', '0345470965', 1982, 14.99, 30, 36, 'The story of Celie, a young African-American woman living in the rural South, and her journey to self-discovery and empowerment.', 6, 2),
  (DEFAULT, 'The Death of Ivan Ilyich', '0486456945', 1886, 8.99, 60, 37, 'The story of Ivan Ilyich, a man who has a mundane and unfulfilling life and is forced to confront his own mortality.', 6, 3),
  (DEFAULT, 'Wuthering Heights', '0486411089', 1847, 9.99, 70, 38, 'The story of the tumultuous relationship between Catherine and Heathcliff, set against the backdrop of the English moors.', 2, 1),
  (DEFAULT, 'The Hitchhikers Guide to the Galaxy', '0345391802', 1979, 11.99, 50, 39, 'The story of Arthur Dent, a hapless human, and his journey through space with an alien friend after the destruction of Earth.', 5, 2),
  (DEFAULT, 'The Shining', '0451210849', 1977, 10.99, 100, 40, 'The story of Jack Torrance, a writer who becomes the caretaker of the Overlook Hotel and is slowly driven mad by the supernatural forces within it.', 8, 3),
  (DEFAULT, 'Enders Game', '0812550706', 1985, 12.99, 40, 20, 'The story of Ender Wiggin, a young boy who is trained to become a military strategist in order to defend humanity against an alien threat.', 1, 1),
  (DEFAULT, 'The Hunger Games', '0439023521', 2008, 13.99, 35, 21, 'The story of Katniss Everdeen, a young woman who is chosen to participate in a brutal government-sponsored survival competition.', 1, 2),
  (DEFAULT, 'The Handmaids Tale', '038549081X', 1985, 14.99, 30, 22, 'A dystopian novel set in a future society where women have no rights and are used solely for reproductive purposes.', 1, 3),
  (DEFAULT, 'The Time Travelers Wife', '0965818675', 2003, 16.99, 20, 23, 'The story of Henry DeTamble, a dashing, adventuresome librarian who travels involuntarily through time, and Clare Abshire, an artist whose life takes a natural sequential course.', 9, 1),
  (DEFAULT, 'The Kite Runner', '1594631931', 2003, 8.99, 60, 24, 'The story of Amir, a young Afghan boy, and his relationship with his best friend Hassan.', 7, 2),
  (DEFAULT, 'The Notebook', '1440591493', 1996, 9.99, 70, 25, 'The story of Noah and Allie, a young couple whose love for each other spans decades and societal boundaries.', 7, 3),
  (DEFAULT, 'The Fault in Our Stars', '0525478817', 2012, 10.99, 100, 26, 'The story of two young cancer patients, Hazel and Gus, who fall in love and navigate the complexities of life and death.', 7, 1),
  (DEFAULT, 'Divergent', '0062348701', 2011, 11.99, 50, 27, 'The story of Tris, a young woman living in a future society where people are divided into factions based on their personality types, and her journey to discover her true identity.', 1, 2),
  (DEFAULT, 'Gone with the Wind', '0394757683', 1936, 12.99, 40, 28, 'The epic story of Scarlett OHara, a strong-willed young woman living in the American South during the Civil War and Reconstruction.', 6, 3),
  (DEFAULT, 'The Chronicles of Narnia: The Lion, the Witch and the Wardrobe', '0064471093', 1950, 14.99, 30, 30, 'The story of the four Pevensie children, who are transported to the magical world of Narnia through a wardrobe.', 1, 1),
  (DEFAULT, 'The Da Vinci Code', '0385504209', 2003, 16.99, 20, 31, 'The story of Robert Langdon, a symbologist, and Sophie Neveu, a cryptologist, as they unravel a series of clues related to a mysterious murder.', 10, 2),
  (DEFAULT, 'The Help', '042523220X', 2009, 8.99, 60, 32, 'The story of three women in 1960s Mississippi, including Aibileen, a black maid, and Skeeter, a white woman, who team up to write a book about the experiences of black maids in the South.', 6, 3),
  (DEFAULT, 'Rebecca', '0394713413', 1938, 9.99, 70, 33, 'The story of a young woman who becomes the second wife of a wealthy widower and must confront the shadow of his deceased first wife, Rebecca.', 7, 1),
  (DEFAULT, 'The Lord of the Rings: The Fellowship of the Ring', '0553593714', 1954, 14.99, 30, 1, 'The first book in the Lord of the Rings trilogy, in which hobbit Frodo Baggins sets out on a quest to destroy the One Ring and defeat the Dark Lord Sauron.', 1, 2),
  (DEFAULT, 'The Lord of the Rings: The Two Towers', '0553593722', 1954, 16.99, 20, 2, 'The second book in the Lord of the Rings trilogy, in which Frodo and Sam continue their journey to destroy the One Ring, while the rest of the fellowship fights against Saurons forces.', 1, 3),
  (DEFAULT, 'The Lord of the Rings: The Return of the King', '0553593730', 1955, 18.99, 10, 3, 'The third book in the Lord of the Rings trilogy, in which the fate of Middle-earth is decided as Frodo and Sam near the end of their journey and the rest of the fellowship fights in the final battle against Sauron.', 1, 1);

INSERT INTO author VALUES (DEFAULT, 'J. D. Salinger');
INSERT INTO author VALUES (DEFAULT, 'Harper Lee');
INSERT INTO author VALUES (DEFAULT, 'Jane Austen');
INSERT INTO author VALUES (DEFAULT, 'F. Scott Fitzgerald');
INSERT INTO author VALUES (DEFAULT, 'Paulo Coelho');
INSERT INTO author VALUES (DEFAULT, 'Gabriel García Márquez');
INSERT INTO author VALUES (DEFAULT, 'Herman Melville');
INSERT INTO author VALUES (DEFAULT, 'Oscar Wilde');
INSERT INTO author VALUES (DEFAULT, 'Sylvia Plath');
INSERT INTO author VALUES (DEFAULT, 'John Steinbeck');
INSERT INTO author VALUES (DEFAULT, 'Fyodor Dostoevsky');
INSERT INTO author VALUES (DEFAULT, 'Ernest Hemingway');
INSERT INTO author VALUES (DEFAULT, 'Charlotte Brontë');
INSERT INTO author VALUES (DEFAULT, 'Aldous Huxley');
INSERT INTO author VALUES (DEFAULT, 'Alice Walker');
INSERT INTO author VALUES (DEFAULT, 'Liev Tolstói');
INSERT INTO author VALUES (DEFAULT, 'Emily Brontë');
INSERT INTO author VALUES (DEFAULT, 'Douglas Adams');
INSERT INTO author VALUES (DEFAULT, 'Stephen King');
INSERT INTO author VALUES (DEFAULT, 'Orson Scott Card');
INSERT INTO author VALUES (DEFAULT, 'Suzanne Collins');
INSERT INTO author VALUES (DEFAULT, 'Margaret Atwood');
INSERT INTO author VALUES (DEFAULT, 'Audrey Niffenegger');
INSERT INTO author VALUES (DEFAULT, 'Khaled Hosseini');
INSERT INTO author VALUES (DEFAULT, 'Nicholas Sparks');
INSERT INTO author VALUES (DEFAULT, 'John Green');
INSERT INTO author VALUES (DEFAULT, 'Veronica Roth');
INSERT INTO author VALUES (DEFAULT, 'Margaret Mitchell');
INSERT INTO author VALUES (DEFAULT, 'C. S. Lewis');
INSERT INTO author VALUES (DEFAULT, 'Dan Brown');
INSERT INTO author VALUES (DEFAULT, 'Kathryn Stockett');
INSERT INTO author VALUES (DEFAULT, 'Daphne du Maurier');
INSERT INTO author VALUES (DEFAULT, 'J. R. R. Tolkien');

INSERT INTO collections VALUES (DEFAULT, 'Lord of The Rings Collection');
INSERT INTO book_collection VALUES (33, 1);
INSERT INTO book_collection VALUES (34, 1);
INSERT INTO book_collection VALUES (35, 1);

INSERT INTO book_author VALUES (1, 1);
INSERT INTO book_author VALUES (2, 2);
INSERT INTO book_author VALUES (3, 3);
INSERT INTO book_author VALUES (4, 4);
INSERT INTO book_author VALUES (5, 5);
INSERT INTO book_author VALUES (6, 6);
INSERT INTO book_author VALUES (7, 7);
INSERT INTO book_author VALUES (8, 8);
INSERT INTO book_author VALUES (9, 9);
INSERT INTO book_author VALUES (10, 10);
INSERT INTO book_author VALUES (11, 11);
INSERT INTO book_author VALUES (12, 12);
INSERT INTO book_author VALUES (13, 13);
INSERT INTO book_author VALUES (14, 14);
INSERT INTO book_author VALUES (15, 15);
INSERT INTO book_author VALUES (16, 16);
INSERT INTO book_author VALUES (17, 17);
INSERT INTO book_author VALUES (18, 18);
INSERT INTO book_author VALUES (19, 19);
INSERT INTO book_author VALUES (20, 20);
INSERT INTO book_author VALUES (21, 21);
INSERT INTO book_author VALUES (22, 22);
INSERT INTO book_author VALUES (23, 23);
INSERT INTO book_author VALUES (25, 25);
INSERT INTO book_author VALUES (26, 26);
INSERT INTO book_author VALUES (27, 27);
INSERT INTO book_author VALUES (28, 28);
INSERT INTO book_author VALUES (29, 29);
INSERT INTO book_author VALUES (30, 30);
INSERT INTO book_author VALUES (31, 31);
INSERT INTO book_author VALUES (32, 32);
INSERT INTO book_author VALUES (33, 33);
INSERT INTO book_author VALUES (34, 33);
INSERT INTO book_author VALUES (35, 33);

INSERT INTO purchase VALUES (DEFAULT, '2022-07-13 14:03:42 +9:00', 1, 'Received');
INSERT INTO purchase VALUES (DEFAULT, '2022-01-30 09:05:56 +8:00', 2, 'Dispatched');
INSERT INTO purchase VALUES (DEFAULT, '2021-12-22 22:21:03 -4:00', 3, 'Delivered');

INSERT INTO purchase_book VALUES (1, 1);
INSERT INTO purchase_book VALUES (2, 2);
INSERT INTO purchase_book VALUES (3, 3);

INSERT INTO delivery VALUES (DEFAULT, '2022-10-18 03:50:35  +0:00', '335-2063 Ligula. St.', '131.96', 1);
INSERT INTO delivery VALUES (DEFAULT, '2022-10-09 10:14:51  +4:00', '596-213 In St.', '104.86', 2);
INSERT INTO delivery VALUES (DEFAULT, '2022-10-28 03:00:56  +9:00', '432-7822 Parturient Av.', '104.80', 3);

INSERT INTO cart VALUES (1, 1);
INSERT INTO cart VALUES (1, 2);
INSERT INTO cart VALUES (2, 3);
INSERT INTO cart VALUES (2, 4);
INSERT INTO cart VALUES (3, 2);
INSERT INTO cart VALUES (3, 3);

INSERT INTO photo VALUES (3, 3);

INSERT INTO faq (question, answer) VALUES 
  ('What is the return policy?', 'We offer a 30-day return policy for most products. If you are not satisfied with your purchase, you can return it for a full refund as long as it is in its original condition and packaging.'),
  ('How do I track my order?', 'You can track your order by logging into your account and viewing your order history. If you do not have an account, you can track your order using the tracking number provided in your shipping confirmation email.'),
  ('Do you offer international shipping?', 'Yes, we offer international shipping to most countries. The cost and delivery time will vary depending on your location.'),
  ('Do you offer gift wrapping?', 'Yes, we offer gift wrapping for an additional fee. You can select this option during the checkout process.'),
  ('Do you have a physical store?', 'We do not have a physical store, but our products are available for purchase online or through our authorized retailers.');

INSERT INTO wishlist VALUES (1, 1);
INSERT INTO wishlist VALUES (1, 4);
INSERT INTO wishlist VALUES (2, 1);
INSERT INTO wishlist VALUES (2, 33);
INSERT INTO wishlist VALUES (3, 2);
INSERT INTO wishlist VALUES (3, 3);
INSERT INTO wishlist VALUES (4, 13);
INSERT INTO wishlist VALUES (4, 20);

INSERT INTO review (rating, comment, review_date, book_id, user_id) VALUES 
  (4, 'I really enjoyed this book! The characters were well-developed and the plot kept me engaged throughout.', '2022-01-01', 1, 1),
  (5, 'This book was amazing! I couldnt put it down. The writing was beautiful and the story was so moving.', '2022-01-02', 2, 2),
  (3, 'It was a good book, but I felt like the ending was a bit rushed. Overall, I would recommend it.', '2022-01-03', 3, 3),
  (4, 'I loved the world-building in this book. The characters were a bit flat, but the plot kept me interested.', '2022-01-04', 4, 4),
  (5, 'This was one of the best books Ive ever read. The writing was beautiful and the story was so compelling. I cant wait to read more from this author.', '2022-01-05', 5, 1),
  (3, 'The concept of this book was interesting, but I felt like the execution was a bit lacking. It wasnt a bad read, but it didnt quite live up to my expectations.', '2022-01-06', 6, 2),
  (4, 'I really enjoyed the character development in this book. The plot was a bit predictable, but overall it was a satisfying read.', '2022-01-07', 7, 3),
  (5, 'This book was incredible! I was hooked from the very first page. The writing was beautiful and the story was so immersive.', '2022-01-08', 8, 4),
  (3, 'It was an okay book. I didnt love it, but I didnt hate it either. It was just kind of...meh.', '2022-01-09', 9, 1),
  (4, 'I really enjoyed the setting and atmosphere of this book. The plot was a bit slow-moving, but overall it was a good read.', '2022-01-10', 10, 2);





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
