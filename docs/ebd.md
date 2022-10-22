# EBD: Database Specification Component

This is it! The book you need, the experience you want, whenever you like.

## A4: Conceptual Data Model

The Conceptual Data Model contains the identification and description of the entities and relationships that are relevant to the database specification.

### 1. Class diagram

The UML diagram in Figure 1 presents the main organisational entities, the relationships between them, attributes and their domains, and the multiplicity of relationships for the **Off The Shelf** platform.

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
| **Justification**   | Table ‘review’ is frequently accessed to obtain a book’s reviews. Filtering is done by exact match, thus an hash type is best suited. For clustering on table ‘review’, id_book is the most interesting since obtaining the reviews for a given book is a frequent request. However, expected update frequency is medium, so no clustering is proposed   |
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
| **Description**  | A book whose stock is non-positive cannot be purchased |
```sql
CREATE FUNCTION book_available() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF EXISTS (SELECT * FROM book WHERE id_book = NEW.id_book AND stock <= 0) THEN
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
```SQL
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
-------------------
```

| **Trigger**      | TRIGGER06                              |
| ---              | ---                                    |
| **Description**  | A blocked user can't purchase books.  |
```sql
-------------------
```

### 4. Transactions
 
> Transactions needed to assure the integrity of the data.  

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

> The database scripts are included in this annex to the EBD component.
> 
> The database creation script and the population script should be presented as separate elements.
> The creation script includes the code necessary to build (and rebuild) the database.
> The population script includes an amount of tuples suitable for testing and with plausible values for the fields of the database.
>
> The complete code of each script must be included in the group's git repository and links added here.

### A.1. Database schema

> The complete database creation must be included here and also as a script in the repository.

### A.2. Database population

> Only a sample of the database population script may be included here, e.g. the first 10 lines. The full script must be available in the repository.

---


## Revision history

Changes made to the first submission:
1. Item 1
1. ..

***
GROUP21gg, DD/MM/2021
 
* Group member 1 name, email (Editor)
* Group member 2 name, email
* ...
