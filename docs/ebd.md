# EBD: Database Specification Component

This is it! The book you need, the experience you want, whenever you like.

## A4: Conceptual Data Model

The Conceptual Data Model contains the identification and description of the entities and relationships that are relevant to the database specification.

### 1. Class diagram

The UML diagram in Figure 1 presents the main organizational entities, the relationships between them, attributes and their domains, and the multiplicity of relationships for the **Off The Shelf** platform.

![img](images/UML.png)  

Figure 1: Off The Shelf conceptual data model in UML.

### 2. Additional Business Rules
 
Additional business rules or restrictions that cannot be conveyed in the UML class diagram, are described in text as UML notes in the diagram or as independent notes in this section.  

- BR01. A book can only be purchased if its stock value is positive.

---


## A5: Relational Schema, validation and schema refinement

This artifact contains the Relational Schema obtained by mapping from the Conceptual Data Model. The Relational Schema includes each relation schema, attributes, domains, primary keys, foreign keys and other integrity rules: UNIQUE, DEFAULT, NOT NULL, CHECK.

### 1. Relational Schema

A textual compact notation is used to document the relational schemas. 

| Relation reference | Relation Compact Notation                        |
| ------------------ | ------------------------------------------------ |
| R01                | faq (**question**, **answer**)|
| R02                | admin (**id_admin**, name NN, email UK NN, password NN)|
| R03                | photo (**id_photo**, image NN, id_book->book, id_user->user UK, id_admin->admin UK)|
| R04                | publisher (**id_publisher**, name NN)|
| R05                | author (**id_author**, name NN)|
| R06                | book_author (**id_book**->book, **id_author**->author)|
| R07                | collection (**id_collection**, name NN)|
| R08                | book_collection (**id_book**->book, **id_collection**->collection)|
| R09                | category (**id_category**, name NN)|
| R10                | review (**id_review**, rating NN CK rating>0 AND rating<=5, comment, date NN DF Today, id_book->book NN, id_user->user NN)|
| R11                | purchase (**id_purchase**, date NN DF Today, id_user->user NN, state NN CK state IN States)|
| R12                | purchase_book (**id_purchase**->purchase, **id_book**->book)|
| R13                | delivery (**id_delivery**, arrival NN, address NN, cost NN CK cost >= 0, id_purchase->purchase UK NN)|
| R14                | book (**id_book**, title NN, isbn UK NN, year, price NN CK price >= 0, stock NN CK stock >= 0, edition, description, id_category->category NN, id_publisher->publisher)|
| R15                | user (**id_user**, username NN, email UK NN, password NN, address, phone, blocked NN DF FALSE)|
| R16                | wishlist (**id_user**->user, **id_book**->book)|
| R17                | cart (**id_user**->user, **id_book**->book)|

Legend:
 - UK = UNIQUE KEY
 - NN = NOT NULL
 - DF = DEFAULT
 - CK = CHECK

### 2. Domains

Specification of additional domains:

| Domain Name | Domain Specification           |
| ----------- | ------------------------------ |
| Today	      | DATE DEFAULT CURRENT_DATE      |
| States    | ENUM ('Received','Dispached','Delivered') |

### 3. Schema validation

To validate the Relational Schema obtained from the Conceptual Data Model, all functional dependencies are identified and the normalization of all relation schemas is accomplished.

| **TABLE R01**   | faq                |
| --------------  | ---                |
| **Keys**        | {question, answer} |
| **Functional Dependencies:** |       |
| none           |none                |
| **NORMAL FORM** | BCNF               |


| **TABLE R02**   | admin              |
| --------------  | ---                |
| **Keys**        | {id_admin}, {email} |
| **Functional Dependencies:** |       |
| FD0201          | {id_admin} -> {name, email, password}  |
| FD0202          | {email} -> {id_admin, name, password}  |
| **NORMAL FORM** | BCNF               |


| **TABLE R03**   | photo             |
| --------------  | ---                |
| **Keys**        | {id_photo}, {id_user}, {id_admin} |
| **Functional Dependencies:** |       |
| FD0301          | {id_photo} -> {image, id_book, id_user, id_admin}  |
| FD0302          | {id_user} -> {id_photo, image, id_book, id_admin}  |
| FD0303          | {id_admin} -> {id_photo, image, id_book, id_user}  |
| **NORMAL FORM** | BCNF               |

| **TABLE R04**   | publisher             |
| --------------  | ---                |
| **Keys**        | {id_publisher} |
| **Functional Dependencies:** |       |
| FD0401          | {id_publisher} -> {name}  |
| **NORMAL FORM** | BCNF               |


| **TABLE R05**   | author             |
| --------------  | ---                |
| **Keys**        | {id_author} |
| **Functional Dependencies:** |       |
| FD0501          | {id_author} -> {name}  |
| **NORMAL FORM** | BCNF               |


| **TABLE R06**   | book_author             |
| --------------  | ---                |
| **Keys**        | {id_book, id_author} |
| **Functional Dependencies:** |       |
| none|none  |
| **NORMAL FORM** | BCNF               |

| **TABLE R07**   | collection             |
| --------------  | ---                |
| **Keys**        | {id_collection} |
| **Functional Dependencies:** |       |
| FD0701          | {id_collection} -> {name}  |
| **NORMAL FORM** | BCNF               |


| **TABLE R08**   | book_collection             |
| --------------  | ---                |
| **Keys**        | {id_book, id_collection} |
| **Functional Dependencies:** |       |
| none|none  |
| **NORMAL FORM** | BCNF               |

| **TABLE R09**   | category             |
| --------------  | ---                |
| **Keys**        | {id_category} |
| **Functional Dependencies:** |       |
| FD0901          | {id_category} -> {name}  |
| **NORMAL FORM** | BCNF               |

| **TABLE R10**   | review             |
| --------------  | ---                |
| **Keys**        | {id_review} |
| **Functional Dependencies:** |       |
| FD1001          | {id_review} -> {rating, comment, date, id_book, id_user} |
| **NORMAL FORM** | BCNF               |

| **TABLE R11**   | puchase            |
| --------------  | ---                |
| **Keys**        |  {id_purchase} |
| **Functional Dependencies:** |       |
| FD1101          | {id_purchase} -> {date, id_user} |
| **NORMAL FORM** | BCNF               |

| **TABLE R12**   | purchase_book          |
| --------------  | ---                |
| **Keys**        |  {id_purchase, id_book} |
| **Functional Dependencies:** |       |
| none|none  |
| **NORMAL FORM** | BCNF               |

| **TABLE R13**   | delivery         |
| --------------  | ---                |
| **Keys**        |  {id_delivery}, {id_purchase} |
| **Functional Dependencies:** |       |
| FD1301          | {id_delivery} -> {arrival, address, cost, id_purchase} |
| FD1302          | {id_purchase} -> {id_delivery, arrival, address, cost} |
| **NORMAL FORM** | BCNF               |

| **TABLE R14**   | book         |
| --------------  | ---                |
| **Keys**        | {id_book}, {isbn} |
| **Functional Dependencies:** |       |
| FD1401          | {id_book} -> {title, isbn, year, price, stock, edition, description, id_category, id_publisher} |
| FD1402          | {isbn} -> {id_book, title, year, price, stock, edition, description, id_category, id_publisher} |
| **NORMAL FORM** | BCNF               |

| **TABLE R15**   | user         |
| --------------  | ---                |
| **Keys**        |{id_user}, {email} |
| **Functional Dependencies:** |       |
| FD1501          | {id_user} -> {username, email, password, address, phone, blocked} |
| FD1502          | {email} -> {id_user, username, password, address, phone, blocked}|
| **NORMAL FORM** | BCNF               |

| **TABLE R16**   | wishlist         |
| --------------  | ---                |
| **Keys**        | {id_user, id_book} |
| **Functional Dependencies:** |       |
| none|none  |
| **NORMAL FORM** | BCNF               |

| **TABLE R17**   | cart         |
| --------------  | ---                |
| **Keys**        | {id_user, id_book} |
| **Functional Dependencies:** |       |
| none|none  |
| **NORMAL FORM** | BCNF               |

Because all relations are in the Boyce–Codd Normal Form (BCNF), the relational schema is also in the BCNF and, therefore, the schema does not need to be further normalised.

---

## A6: Indexes, triggers, transactions and database population

This artifact contains the physical schema of the database, the identification and characterisation of the indexes, the support of data integrity rules with triggers and the definition of the database user-defined functions.

Furthermore, it also shows the database transactions needed to assure the integrity of the data in the presence of concurrent accesses. For each transaction, the isolation level is explicitly stated and justified.

This artifact also contains the database's workload as well as the complete database creation script, including all SQL necessary to define all integrity constraints, indexes and triggers. Finally, this artifact also includes a separate script with INSERT statements to populate the database.

### 1. Database Workload
 
The workload includes an estimate of the number of tuples for each relation and also the estimated growth.

| **Relation reference** | **Relation Name** | **Order of magnitude**        | **Estimated growth** |
| ------------------ | ------------- | ------------------------- | -------- |
| R01                | faq        | dozens | one per month |
| R02                | admin        | units | no growth |
| R03                | photo        | tens of thousands | dozens per day |
| R04                | publisher        | hundreds | one per day |
| R05                | author       | thousands | one per day |
| R06                | book_author        | thousands | one per day |
| R07                | collection        | hundreds | one per day |
| R08                | book_collection        | hundreds | one per day |
| R09                | category        | hundreds | one per month |
| R10                | review        | tens of thousands | hundreds per week |
| R11                | purchase        | tens of thousands | hundreds per day |
| R12                | purchase_book        | tens of thousands | hundreds per day |
| R13                | delivery        | tens of thousands | hundreds per day |
| R14                | book       | thousands | one per day |
| R15                | user        | tens of thousands | dozens per day |
| R16                | wishlist        | tens of thousands | hundreds per day |
| R17                | cart        | tens of thousands | hundreds per week |

### 2. Proposed Indices

#### 2.1. Performance Indices
 
Performance indexes are applied to improve the performance of select queries. These are the ones proposed.

| **Index**           | IDX01                                  |
| ---                 | ---                                    |
| **Relation**        | purchase    |
| **Attribute**       | id_user   |
| **Type**            | Hash              |
| **Cardinality**     | Medium |
| **Clustering**      | No                |
| **Justification**   | Table ‘purchase’ is frequently accessed to view a user’s purchase history. Filtering is done by exact match, thus an hash type is best suited. Expected update frequency is medium, so no clustering is proposed.   |
```sql
CREATE INDEX user_purchase ON purchase USING hash (id_user);
```

| **Index**           | IDX02                                  |
| ---                 | ---                                    |
| **Relation**        | book    |
| **Attribute**       | id_category   |
| **Type**            | B-tree              |
| **Cardinality**     | Medium |
| **Clustering**      | Yes               |
| **Justification**   | The action of getting the books of a chosen category is quite frequent. Filtering is done by exact match, thus an hash type index would be best suited. However, since we also want to apply clustering based on this index, and clustering is not possible on hash type indexes, we opted for a b-tree index. Update frequency is low and cardinality is medium so it's a good candidate for clustering.   |
```sql
CREATE INDEX book_category ON book USING btree (id_category);
CLUSTER book USING book_category;
```

| **Index**           | IDX03                                  |
| ---                 | ---                                    |
| **Relation**        | review    |
| **Attribute**       | id_book   |
| **Type**            | Hash             |
| **Cardinality**     | Medium |
| **Clustering**      | No               |
| **Justification**   | Table ‘review’ is frequently accessed to obtain a book’s reviews. Filtering is done by exact match, thus an hash type is best suited. For clustering on table ‘review’, id_book is the most interesting since obtaining the reviews for a given book is a frequent request. However, expected update frequency is medium, so no clustering is proposed.   |
```sql
CREATE INDEX book_review ON review USING hash (id_book);
```

#### 2.2. Full-text Search Indices 

Full-text search indexes are applied to provide keyword based search over records of the database. Results using FTS are ranked by relevance and can use signals from multiple tables and with different weights.

| **Index**           | IDX04                                  |
| ---                 | ---                                    |
| **Relation**        | book    |
| **Attribute**       | title   |
| **Type**            | GIN              |
| **Clustering**      | No                |
| **Justification**   | To provide full-text search features to look for works based on matching titles. The index type is GIN because the indexed fields are not expected to change often.  |
```sql
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
```

### 3. Triggers
 
Triggers and user defined functions are used to automate tasks depending on changes to the database. Business rules are usually enforced using a combination of triggers and user defined functions. 

| **Trigger**      | TRIGGER01                              |
| ---              | ---                                    |
| **Description**  | A book whose stock is non-positive cannot be purchased. |
```sql
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
```

| **Trigger**      | TRIGGER02                              |
| ---              | ---                                    |
| **Description**  | A book's stock decreases by 1 after a single purchase.  |
```sql
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
```

| **Trigger**      | TRIGGER03                              |
| ---              | ---                                    |
| **Description**  | A book is removed from an user's wishlist after the user adds it to the shopping cart.  |
```sql
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
```

| **Trigger**      | TRIGGER04                              |
| ---              | ---                                    |
| **Description**  | A book is removed from an user's shopping cart after the user purchases it.  |
```sql
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
```

| **Trigger**      | TRIGGER05                              |
| ---              | ---                                    |
| **Description**  | A blocked user can't submit reviews.  |
```sql
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
```

| **Trigger**      | TRIGGER06                              |
| ---              | ---                                    |
| **Description**  | A blocked user can't purchase books.  |
```sql
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
```

### 4. Transactions
 
Transactions are used to assure the integrity of the data when multiple operations are necessary. 

| Transaction     | TRAN01                              |
| --------------- | ----------------------------------- |
| Justification   | Verifies that all books in collections and cart are in stock. As we use only Selects, it's READ ONLY.  |
| Isolation level | SERIALIZABLE READ ONLY |
```sql 
BEGIN TRANSACTION; 
SET TRANSACTION ISOLATION LEVEL SERIALIZABLE READ ONLY;

SELECT collection_name from collections inner join book_collection, book
    where stock != 0
    order by collection_name ASC LIMIT 5;

SELECT title from book inner join cart
    where stock > 0
    order by title ASC;

END TRANSACTION;
```

| Transaction     | TRAN02                             |
| --------------- | ----------------------------------- |
| Justification   | Makes sure inserts into `users` and `book` are done correctly. We use REPEATABLE READ as we should only access data commited before the beginning of the transaction; otherwise, there might be conflicts and there could be confliting entries in the database  |
| Isolation level | REPEATABLE READ |
```sql 
BEGIN TRANSACTION; 
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;

INSERT INTO users VALUES ($username, $email, $user_password, $user_address, $phone, $blocked);

INSERT INTO book VALUES ($title,  $isbn, $year, $price, $stock, $book_edition, $book_description, $id_category, $id_publisher);

END TRANSACTION;
```

## Annex A. SQL Code

The complete SQL code (i.e. including CREATE statements but also indices, triggers, stored procedures and user defined functions) is included as an annex to the EBD component. The database creation script and the database population script are included as separate elements.

### A.1. Database schema

- Link to database creation script: [creation.sql](/proj/creation.sql)

```sql
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
```

### A.2. Database population

- Link to database population script: [population.sql](/proj/population.sql)

```sql
/*
Populate Tables (sample of the database population script)
*/

/*Faq*/
/*(question, answer)*/
/*20*/
INSERT INTO faq VALUES
  ("Nulla facilisi. Sed neque. Sed eget lacus. Mauris non dui nec urna suscipit nonummy. Fusce fermentum fermentum arcu. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae Phasellus ornare. Fusce","natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin vel nisl. Quisque fringilla euismod enim. Etiam"),
  ("commodo hendrerit. Donec porttitor tellus non magna. Nam ligula elit, pretium et, rutrum non, hendrerit id, ante. Nunc mauris sapien, cursus in, hendrerit consectetuer, cursus et, magna. Praesent interdum ligula eu","a felis ullamcorper viverra. Maecenas iaculis aliquet diam. Sed diam lorem, auctor quis, tristique ac, eleifend vitae, erat. Vivamus nisi. Mauris nulla. Integer urna. Vivamus molestie dapibus ligula. Aliquam erat volutpat. Nulla dignissim. Maecenas ornare egestas ligula. Nullam feugiat placerat velit. Quisque varius. Nam"),
  ("sed pede nec ante blandit viverra. Donec tempus, lorem fringilla ornare placerat, orci lacus vestibulum lorem, sit amet ultricies sem magna nec quam. Curabitur vel lectus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus","Duis volutpat nunc sit amet metus. Aliquam erat volutpat. Nulla facilisis. Suspendisse commodo tincidunt nibh. Phasellus nulla. Integer vulputate, risus a ultricies adipiscing, enim mi tempor lorem, eget"),
  ("Proin mi. Aliquam gravida mauris ut mi. Duis risus odio, auctor vitae, aliquet nec, imperdiet nec, leo. Morbi neque tellus, imperdiet non, vestibulum nec, euismod in, dolor. Fusce feugiat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam auctor, velit eget","velit eu sem. Pellentesque ut ipsum ac mi eleifend egestas. Sed pharetra, felis eget varius ultrices, mauris ipsum porta elit, a feugiat tellus lorem eu metus. In lorem. Donec elementum, lorem"),
  ("eget metus. In nec orci. Donec nibh. Quisque nonummy ipsum non arcu. Vivamus sit amet risus. Donec egestas.","nostra, per inceptos hymenaeos. Mauris ut quam vel sapien imperdiet ornare. In faucibus. Morbi vehicula. Pellentesque tincidunt tempus risus. Donec egestas. Duis ac arcu. Nunc mauris. Morbi non sapien molestie orci tincidunt adipiscing. Mauris molestie"),
  ("dignissim tempor arcu. Vestibulum ut eros non enim commodo hendrerit. Donec porttitor tellus non magna. Nam ligula elit, pretium et, rutrum non, hendrerit","Nulla facilisis. Suspendisse commodo tincidunt nibh. Phasellus nulla. Integer vulputate, risus a ultricies adipiscing, enim mi tempor lorem, eget mollis lectus pede et risus. Quisque libero lacus, varius et, euismod et, commodo at, libero. Morbi accumsan laoreet ipsum."),
  ("sapien molestie orci tincidunt adipiscing. Mauris molestie pharetra nibh. Aliquam ornare, libero at auctor ullamcorper, nisl arcu iaculis enim, sit amet ornare lectus justo eu","dis parturient montes, nascetur ridiculus mus. Proin vel arcu eu odio tristique pharetra. Quisque ac libero nec ligula consectetuer rhoncus. Nullam velit dui, semper et,"),
  ("scelerisque neque sed sem egestas blandit. Nam nulla magna, malesuada vel, convallis in, cursus et, eros. Proin ultrices. Duis volutpat nunc","sagittis augue, eu tempor erat neque non quam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam fringilla cursus purus. Nullam scelerisque neque sed sem egestas blandit. Nam nulla magna, malesuada vel, convallis in,"),
  ("Nam porttitor scelerisque neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu turpis. Nulla aliquet. Proin velit. Sed malesuada augue ut lacus. Nulla tincidunt, neque vitae semper","lacus. Ut nec urna et arcu imperdiet ullamcorper. Duis at lacus. Quisque purus sapien, gravida non, sollicitudin a, malesuada id, erat. Etiam vestibulum massa rutrum magna. Cras convallis"),
  ("ligula tortor, dictum eu, placerat eget, venenatis a, magna. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam laoreet, libero et tristique","pede. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin vel arcu eu odio tristique pharetra. Quisque");

/*Admins*/
/*(id_admin, admin_name, email, admin_password)*/
/*10*/
INSERT INTO admins VALUES
  (3030,"Stuart Maxwell","stuartmaxwell7851@icloud.com","JtV8zo5B8JN"),
  (3223,"Addison Chambers","addisonchambers2592@outlook.com","WxY6xi4I0MY"),
  (1012,"Iona Fletcher","ionafletcher@hotmai.com","JcI5tp4H7JO"),
  (5188,"Madeline Tate","madelinetate@yahoo.com","XdC9ew2N8PN"),
  (2274,"Oleg Hensley","oleghensley5863@outlook.net","QmI1jj5Y4HI"),
  (4114,"Janna Roberts","jannaroberts6170@icloud.org","MdH6gw8J1CS"),
  (9954,"Rhona Perez","rhonaperez3509@icloud.com","AwT6nm6I4UF"),
  (6573,"Berk Buchanan","berkbuchanan2943@icloud.org","VjN1fv4Z2WV"),
  (8202,"Dara Burks","daraburks@icloud.net","MeQ3yq3D7TG"),
  (6306,"Trevor Malone","trevormalone5887@hotmai.org","FhC6jd3X1VV");

/*Publisher*/
/*(id_publisher, publisher_name)*/
/*20*/
INSERT INTO publisher VALUES
  (5746,"quam"),
  (9469,"Nam tempor"),
  (1313,"congue"),
  (7050,"sit amet"),
  (2056,"Ut"),
  (9698,"nisl. Maecenas"),
  (3921,"Quisque ornare"),
  (4797,"ipsum porta"),
  (3876,"erat"),
  (8130,"commodo at,");

/*Author*/
/*(id_author, author_name)*/
/*20*/
INSERT INTO author VALUES
  (7695,"quis"),
  (2832,"ipsum"),
  (4702,"commodo ipsum."),
  (8874,"nisl. Quisque"),
  (2768,"urna suscipit"),
  (5912,"Nullam"),
  (2424,"ut,"),
  (2773,"a,"),
  (4483,"Ut"),
  (9641,"porttitor eros");

/*Collections*/
/*(id_collection, collection_name)*/
/*20*/
INSERT INTO collections VALUES
  (1149,"mollis."),
  (9944,"velit"),
  (2187,"malesuada id,"),
  (9895,"orci,"),
  (3311,"nisl sem,"),
  (7813,"lorem,"),
  (3705,"Morbi"),
  (4005,"neque."),
  (3254,"senectus et"),
  (2964,"dis parturient");

/*Category*/
/*(id_category, category_name)*/
/*20*/
INSERT INTO category VALUES
  (1931,"cursus et,"),
  (8947,"dui"),
  (1508,"libero et"),
  (7138,"gravida"),
  (1305,"dictum"),
  (3431,"erat"),
  (3286,"tellus"),
  (8912,"sit"),
  (5836,"cursus"),
  (4306,"ultricies");

/*Users*/
/*(id_user, username, email, user_password, user_address, phone, blocked)*/
/*20*/
INSERT INTO users VALUES
  (7814, "Amaya Martinez"   , "amayamartinez@hotmail.org"  , "Yi5j66VlF4DJ", "696 Magna. Street"            , "0800 835 4424"  , "No"),
  (1112, "Josephine Morales", "josephinemorales@yahoo.org" , "Pw2y92MsY9NU", "Ap #600-1576 In St."          , "070 2878 8712"  , "No"),
  (1878, "Sonya Kent"       , "sonyakent@yahoo.org"        , "Uh3p40MpI3ZY", "384-8823 A St."               , "0800 1111"      , "No"),
  (6259, "Kadeem Cooley"    , "kadeemcooley8001@icloud.edu", "Hn5f12WzL2LV", "P.O. Box 630, 1505 Est Street", "0343 125 3166"  , "Yes"),
  (2608, "Richard Duke"     , "richardduke8656@hotmail.edu", "Qr5i67XkI3II", "Ap #706-5476 Laoreet Ave"     , "055 4356 9231"  , "No"),
  (7686, "Ina Blanchard"    , "inablanchard@outlook.org"   , "Vd1s68SyH7SY", "578-9276 Ut Road"             , "(024) 1529 2472", "No"),
  (4357, "Castor Craig"     , "castorcraig@outlook.edu"    , "Se1p60RhV8NC", "Ap #985-2331 Auctor Av."      , "0851 856 6448"  , "No"),
  (4066, "Haley Barker"     , "haleybarker@yahoo.org"      , "Lj9w14OqT6GL", "P.O. Box 472, 9907 Urna Rd."  , "070 5019 6658"  , "Yes"),
  (5300, "Alden Hale"       , "aldenhale@icloud.net"       , "Gl2j03OzT4LQ", "896-8186 Cras Road"           , "070 8547 5067"  , "No"),
  (4502, "Randall Bass"     , "randallbass@hotmail.org"    , "Ns1j33XsR6LY", "P.O. Box 498, 7984 Risus. Rd.", "0800 1111"      , "No");

/*Purchase*/
/*(id_purchase, purchase_date, id_user, purchase_state)*/
/*10*/
INSERT INTO purchase VALUES
  (2729,"2022-07-13 14:03:42 +9:00",8020, 'Received'),
  (8131,"2022-01-30 09:05:56 +8:00",6286, 'Received'),
  (7922,"2021-12-22 22:21:03 -4:00",3197, 'Received'),
  (9730,"2021-04-04 12:17:47 -4:00",1242, 'Received'),
  (9061,"2021-07-04 01:43:53 -8:00",4701, 'Dispatched'),
  (3332,"2022-03-22 16:50:18 +2:00",3616, 'Dispatched'),
  (1942,"2021-10-18 22:29:36 +7:00",4525, 'Dispatched'),
  (2356,"2021-07-17 17:33:03 -0:00",2932, 'Dispatched'),
  (9666,"2021-11-13 13:42:04 +9:00",8904, 'Delivered'),
  (3604,"2022-04-05 05:17:14 +4:00",3770, 'Delivered');

/*Book*/
/*(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher)*/
/*40*/
INSERT INTO book VALUES
  (5675, "aliquam arcu. Aliquam ultrices iaculis odio.", 5351034105, 1918, "112.90", 5 , 5, "est, congue a, aliquet vel, vulputate eu, odio. Phasellus at augue id ante dictum cursus. Nunc mauris elit, dictum eu, eleifend nec, malesuada ut, sem. Nulla interdum. Curabitur dictum. Phasellus in felis. Nulla tempor augue ac ipsum. Phasellus vitae mauris sit amet lorem semper auctor."                                                                                                                                                                                                                                                  , 1931, 5746),
  (7237, "dolor. Donec fringilla. Donec feugiat metus" , 4733319526, 1970, "162.18", 29, 6, "commodo auctor velit. Aliquam nisl. Nulla eu neque pellentesque massa lobortis ultrices. Vivamus rhoncus. Donec est. Nunc ullamcorper, velit in aliquet lobortis, nisi nibh lacinia orci, consectetuer euismod est arcu ac orci. Ut semper pretium neque. Morbi quis urna. Nunc quis arcu vel quam dignissim pharetra. Nam ac nulla. In tincidunt congue turpis. In condimentum. Donec at"                                                                                                                                                        , 8947, 9469),
  (9930, "ornare, elit elit fermentum risus, at"       , 3638368148, 2022, "7.07"  , 4 , 0, "nulla. In tincidunt congue turpis. In condimentum. Donec at arcu. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae Donec tincidunt. Donec vitae erat vel pede blandit congue. In scelerisque scelerisque dui. Suspendisse ac metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc nulla vulputate dui, nec tempus mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae diam. Proin dolor. Nulla semper tellus id nunc interdum feugiat."                                    , 1508, 1313),
  (9058, "egestas a, dui. Cras pellentesque. Sed"      , 1559765489, 1962, "111.84", 30, 4, "eros turpis non enim. Mauris quis turpis vitae purus gravida sagittis. Duis gravida. Praesent eu nulla at sem molestie sodales. Mauris blandit enim consequat purus. Maecenas libero est, congue a, aliquet vel, vulputate eu, odio. Phasellus at augue id ante dictum cursus. Nunc mauris elit, dictum eu, eleifend nec, malesuada ut, sem. Nulla interdum. Curabitur dictum."                                                                                                                                                                   , 7138, 7050),
  (5531, "Quisque tincidunt pede ac urna. Ut"          , 7100265623, 2022, "55.89" , 18, 3, "sit amet ornare lectus justo eu arcu. Morbi sit amet massa. Quisque porttitor eros nec tellus. Nunc lectus pede, ultrices a, auctor non, feugiat nec, diam. Duis mi enim, condimentum eget, volutpat ornare, facilisis eget, ipsum. Donec sollicitudin adipiscing ligula. Aenean gravida nunc sed pede. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin vel arcu eu odio tristique pharetra. Quisque"                                                                                                 , 1305, 2056),
  (6934, "libero. Proin mi. Aliquam gravida mauris"    , 3985700232, 2007, "177.01", 2 , 7, "tempor lorem, eget mollis lectus pede et risus. Quisque libero lacus, varius et, euismod et, commodo at, libero. Morbi accumsan laoreet ipsum. Curabitur consequat, lectus sit amet luctus vulputate, nisi sem semper erat, in consectetuer ipsum nunc id enim. Curabitur massa. Vestibulum accumsan neque et nunc. Quisque ornare tortor at risus. Nunc ac sem ut dolor dapibus gravida."                                                                                                                                                        , 3431, 9698),
  (1617, "orci lacus vestibulum lorem, sit amet"       , 7807449319, 1948, "179.27", 1 , 2, "ut, nulla. Cras eu tellus eu augue porttitor interdum. Sed auctor odio a purus. Duis elementum, dui quis accumsan convallis, ante lectus convallis est, vitae sodales nisi magna sed dui. Fusce aliquam, enim nec tempus scelerisque, lorem ipsum sodales purus, in molestie tortor nibh sit amet orci. Ut sagittis lobortis mauris. Suspendisse aliquet molestie tellus. Aenean egestas hendrerit neque. In ornare sagittis felis. Donec tempor, est"                                                                                            , 3286, 3921),
  (1738, "vel est tempor bibendum. Donec felis"        , 7155626270, 1904, "39.49" , 37, 7, "bibendum. Donec felis orci, adipiscing non, luctus sit amet, faucibus ut, nulla. Cras eu tellus eu augue porttitor interdum. Sed auctor odio a purus. Duis elementum, dui quis accumsan convallis, ante lectus convallis est, vitae sodales nisi magna sed dui. Fusce aliquam, enim nec tempus scelerisque, lorem ipsum sodales purus, in molestie tortor nibh sit amet orci. Ut sagittis lobortis mauris. Suspendisse aliquet molestie tellus. Aenean egestas hendrerit neque. In ornare sagittis felis. Donec tempor, est ac mattis semper, dui", 8912, 4797),
  (4111, "ultricies sem magna nec quam. Curabitur"     , 6001574761, 1925, "152.70", 23, 4, "Duis dignissim tempor arcu. Vestibulum ut eros non enim commodo hendrerit. Donec porttitor tellus non magna. Nam ligula elit, pretium et, rutrum non, hendrerit id, ante. Nunc mauris sapien, cursus in, hendrerit consectetuer, cursus et, magna. Praesent interdum ligula eu enim. Etiam imperdiet dictum magna. Ut tincidunt orci quis lectus. Nullam suscipit, est ac facilisis facilisis, magna tellus faucibus leo, in lobortis"                                                                                                            , 5836, 3876),
  (4601, "ornare, lectus ante dictum mi, ac"           , 1009054957, 2017, "92.34" , 23, 7, "ut, sem. Nulla interdum. Curabitur dictum. Phasellus in felis. Nulla tempor augue ac ipsum. Phasellus vitae mauris sit amet lorem semper auctor. Mauris vel turpis. Aliquam adipiscing lobortis risus. In mi pede, nonummy ut, molestie in, tempus eu, ligula. Aenean euismod mauris eu elit. Nulla facilisi. Sed neque. Sed eget lacus. Mauris non dui nec urna suscipit"                                                                                                                                                                        , 4306, 8130);

/*Photo*/
/*(id_photo,photo_image,id_book,id_user,id_admin)*/
/*40*/
INSERT INTO photo VALUES
  (9105, "https://", 5675, 7814, 3030),
  (7623, "https://", 7237, 1112, 3223),
  (5116, "https://", 9930, 1878, 1012),
  (8408, "https://", 9058, 6259, 5188),
  (4958, "http://" , 5531, 2608, 2274),
  (1988, "https://", 6934, 7686, 4114),
  (1363, "https://", 1617, 4357, 9954),
  (6250, "http://" , 1738, 4066, 6573),
  (1019, "https://", 4111, 5300, 8202),
  (8832, "http://" , 4601, 4502, 6306);

/*Book_Author*/
/*(id_book, id_author)*/
/*40*/
INSERT INTO book_author VALUES
  (5675,7695),
  (7237,2832),
  (9930,4702),
  (9058,8874),
  (5531,2768),
  (6934,5912),
  (1617,2424),
  (1738,2773),
  (4111,4483),
  (4601,9641);

/*Book_Collection*/
/*(id_book, id_collections)*/
/*40*/
INSERT INTO book_collection VALUES
  (5675,1149),
  (7237,9944),
  (9930,2187),
  (9058,9895),
  (5531,3311),
  (6934,7813),
  (1617,3705),
  (1738,4005),
  (4111,3254),
  (4601,2964);

/*Review*/
/*(id_review, rating, comment, review_date, id_book, id_user)*/
/*40*/
INSERT INTO review VALUES
  (4, 2, "Mauris nulla. Integer urna. Vivamus molestie dapibus ligula. Aliquam erat volutpat. Nulla dignissim. Maecenas ornare egestas ligula. Nullam feugiat placerat"                                                                                                                                                                                                     , "2022-03-11 08:27:08  +8:00" , 5675, 7814),
  (4, 3, "neque. Sed eget lacus. Mauris non dui nec urna suscipit nonummy. Fusce fermentum fermentum arcu. Vestibulum"                                                                                                                                                                                                                                                      , "2022-12-23 23:36:01 +1:00", 7237, 1112),
  (7, 3, "lorem, auctor quis, tristique ac, eleifend vitae, erat. Vivamus nisi. Mauris nulla. Integer urna. Vivamus molestie dapibus ligula. Aliquam erat volutpat. Nulla dignissim. Maecenas ornare egestas ligula. Nullam feugiat placerat velit. Quisque varius. Nam porttitor scelerisque neque. Nullam"                                                                , "2022-11-17 23:02:59  +9:00" , 9930, 1878),
  (6, 1, "sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Mauris ut quam vel sapien imperdiet ornare. In faucibus. Morbi vehicula. Pellentesque tincidunt tempus risus. Donec egestas. Duis ac arcu. Nunc mauris. Morbi non sapien molestie orci tincidunt adipiscing. Mauris molestie pharetra nibh. Aliquam ornare, libero at auctor ullamcorper,", "2023-03-01 04:41:22  +7:00" , 9058, 6259),
  (1, 4, "malesuada fringilla est. Mauris eu turpis. Nulla aliquet. Proin velit. Sed malesuada augue ut lacus. Nulla tincidunt, neque vitae semper egestas, urna justo faucibus lectus, a sollicitudin orci sem eget massa. Suspendisse eleifend. Cras sed leo. Cras vehicula aliquet libero. Integer in magna. Phasellus"                                                  , "2023-05-03 19:57:31 +1:00", 5531, 2608),
  (1, 2, "mattis semper, dui lectus rutrum urna, nec luctus felis purus ac tellus. Suspendisse sed dolor. Fusce mi lorem, vehicula et, rutrum eu, ultrices sit amet, risus. Donec nibh enim, gravida sit amet, dapibus id, blandit at, nisi. Cum sociis"                                                                                                                    , "2022-03-04 22:39:46 +5:00", 6934, 7686),
  (5, 1, "Cras convallis convallis dolor. Quisque tincidunt pede ac urna. Ut tincidunt vehicula risus. Nulla eget metus eu erat"                                                                                                                                                                                                                                            , "2023-02-25 10:52:24 +1:00", 1617, 4357),
  (1, 3, "eget massa. Suspendisse eleifend. Cras sed leo. Cras vehicula aliquet libero. Integer in magna. Phasellus dolor elit, pellentesque a, facilisis non, bibendum sed, est. Nunc laoreet lectus quis massa. Mauris"                                                                                                                                                   , "2023-03-07 00:09:53 +2:00", 1738, 4066),
  (5, 1, "magna. Phasellus dolor elit, pellentesque a, facilisis non, bibendum sed,"                                                                                                                                                                                                                                                                                        , "2023-03-24 22:41:05 +2:00", 4111, 5300),
  (7, 0, "nec luctus felis purus ac tellus. Suspendisse sed dolor. Fusce mi lorem, vehicula et, rutrum eu, ultrices sit amet, risus. Donec nibh enim,"                                                                                                                                                                                                                      , "2023-09-14 00:05:19  +8:00" , 4601, 4502);

/*Purchase_book*/
/*(id_purchase, id_book)*/
/*40*/
INSERT INTO purchase_book VALUES
  (6457,5675),
  (6319,7237),
  (5911,9930),
  (7600,9058),
  (6605,5531),
  (5143,6934),
  (8716,1617),
  (9028,1738),
  (4585,4111),
  (8364,4601);

/*Delivery*/
/*(id_delivery, arrival, delivery_address, cost, id_purchase)*/
/*40*/
INSERT INTO delivery VALUES
  (2626, "2023-05-18 03:50:35  +0:00" , "335-2063 Ligula. St."        , "131.96", 1340),
  (3638, "2023-09-09 10:14:51  +4:00" , "596-213 In St."              , "104.86", 1757),
  (1029, "2023-06-28 03:00:56  +9:00" , "432-7822 Parturient Av."     , "104.80", 9731),
  (8297, "2022-08-27 12:03:07  +3:00" , "979-3302 Suspendisse Road"   , "174.59", 5930),
  (6032, "2023-01-26 05:53:02 +10:00", "257-1328 Sed Road"           , "156.08", 7683),
  (9842, "2022-10-26 04:46:01  +4:00" , "Ap #490-8898 Eleifend Ave"   , "54.71" , 7724),
  (3314, "2023-02-18 11:06:34  +1:00" , "Ap #132-901 Pellentesque St.", "146.63", 3006),
  (5034, "2023-02-16 00:21:30 +13:00", "Ap #912-1067 Tempor Av."     , "68.53" , 9888),
  (4490, "2023-07-08 20:19:33  +1:00" , "Ap #336-634 Pede, Street"    , "193.12", 3450),
  (8828, "2023-07-13 04:37:46  +0:00" , "385-9529 Placerat Road"      , "122.76", 8632);

/*Wishlist*/
/*(id_user, id_book)*/
/*20*/
INSERT INTO wishlist VALUES
  (7814,5675),
  (1112,7237),
  (1878,9930),
  (6259,9058),
  (2608,5531),
  (7686,6934),
  (4357,1617),
  (4066,1738),
  (5300,4111),
  (4502,4601);

/*Cart*/
/*(id_user, id_book)*/
/*20*/
INSERT INTO cart VALUES
  (7814,5675),
  (1112,7237),
  (1878,9930),
  (6259,9058),
  (2608,5531),
  (7686,6934),
  (4357,1617),
  (4066,1738),
  (5300,4111),
  (4502,4601);

-- removed for brevity

-----------------------------------------
-- end
-----------------------------------------
```

---


## Revision history

Changes made to the first submission:
1. Item 1
1. ..

***
GROUP2232, 23/10/2022

* Afonso da Silva Pinto, up202008014@fe.up.pt
* Afonso José Pinheiro Oliveira Esteves Abreu, up202008552@fe.up.pt
* Diogo Filipe Ferreira da Silva, up202004288@fe.up.pt
* Rúben Lourinha Monteiro, up202006478@fe.up.pt
