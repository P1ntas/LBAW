# EBD: Database Specification Component

This is it! The book you need, the experience you want, whenever you like.

## A4: Conceptual Data Model

The Conceptual Data Model contains the identification and description of the entities and relationships that are relevant to the database specification.

### 1. Class diagram

The UML diagram in Figure 1 presents the main organisational entities, the relationships between them, attributes and their domains, and the multiplicity of relationships for the **Off The Shelf** platform.

![img](images/UML.png)  

Figure 1: Off The Shelf conceptual data model in UML.

### 2. Additional Business Rules
 
> Business rules can be included in the UML diagram as UML notes or in a table in this section.


---


## A5: Relational Schema, validation and schema refinement

> Brief presentation of the artefact goals.

### 1. Relational Schema

> Relation schemas are specified in the compact notation:  

| Relation reference | Relation Compact Notation                        |
| ------------------ | ------------------------------------------------ |
| R01                | FAQ (**question**, **answer**)|
| R02                | admin (**idAdmin**, name NN, email UK NN, password NN)|
| R03                | photo (**idPhoto**, image NN, idBook->book, idUser->user UK, idAdmin->admin UK)|
| R04                | publisher (**idPublisher**, name NN)|
| R05                | author (**idAuthor**, name NN)|
| R06                | book_author (**idBook**->book, **idAuthor**->author)|
| R07                | collection (**idCollection**, name NN)|
| R08                | book_collection (**idBook**->book, **idCollection**->collection)|
| R09                | category (**idCategory**, name NN)|
| R10                | review (**idReview**, rating NN CK rating>0 AND rating<=5, comment, date NN, idBook->book NN, idUser->user NN)|
| R11                | purchase (**idPurchase**, date NN, idUser->user NN)|
| R12                | received (**idPurchase**->purchase)|
| R13                | dispatched (**idPurchase**->purchase)|
| R14                | delivered (**idPurchase**->purchase)|
| R15                | purchase_book (**idPurchase**->purchase, **idBook**->book)|
| R16                | delivery (**idDelivery**, arrival NN, address NN, cost NN CK cost >= 0, idPurchase->purchase UK NN)|
| R17                | book (**idBook**, title NN, isbn NN, year, price NN CK price >= 0, edition, idCategory->category NN, idPublisher->publisher)|
| R18                | user (**idUser**, username NN, email UK NN, password NN, address, phone)|
| R19                | wishlist (**idUser**->user, **idBook**->book)|
| R20                | cart (**idUser**->user, **idBook**->book)|

### 2. Domains

> The specification of additional domains can also be made in a compact form, using the notation:  

| Domain Name | Domain Specification           |
| ----------- | ------------------------------ |
| Today	      | DATE DEFAULT CURRENT_DATE      |
| State    | ENUM ('Received','Dispached','Delivered') |

### 3. Schema validation

> To validate the Relational Schema obtained from the Conceptual Model, all functional dependencies are identified and the normalization of all relation schemas is accomplished. Should it be necessary, in case the scheme is not in the Boyce–Codd Normal Form (BCNF), the relational schema is refined using normalization.  

| **TABLE R01**   | FAQ                |
| --------------  | ---                |
| **Keys**        | {question, answer} |
| **Functional Dependencies:** |       |
| none           |none                |
| **NORMAL FORM** | BCNF               |


| **TABLE R02**   | admin              |
| --------------  | ---                |
| **Keys**        | {idAdmin}, {email} |
| **Functional Dependencies:** |       |
| FD0101          | idAdmin -> {name, email, password}  |
| FD0101          | email -> {idAdmin, name, password}  |
| **NORMAL FORM** | BCNF               |


| **TABLE R03**   | photo             |
| --------------  | ---                |
| **Keys**        | {idPhoto}, {idUser}, {idAdmin} |
| **Functional Dependencies:** |       |
| FD0101          | idPhoto -> {image, idBook, idUser, idAdmin}  |
| FD0101          | idUser -> {idPhoto, image, idBook, idAdmin}  |
| FD0101          | idAdmin -> {idPhoto, image, idBook, idUser}  |
| **NORMAL FORM** | BCNF               |

| **TABLE R04**   | publisher             |
| --------------  | ---                |
| **Keys**        | {idPublisher} |
| **Functional Dependencies:** |       |
| FD0101          | idPublisher -> {name}  |
| **NORMAL FORM** | BCNF               |


| **TABLE R05**   | author             |
| --------------  | ---                |
| **Keys**        | {idAuthor} |
| **Functional Dependencies:** |       |
| FD0101          | idAuthor -> {name}  |
| **NORMAL FORM** | BCNF               |


| **TABLE R06**   | book_author             |
| --------------  | ---                |
| **Keys**        | {idBook, idAuthor} |
| **Functional Dependencies:** |       |
| none|none  |
| **NORMAL FORM** | BCNF               |

| **TABLE R07**   | collection             |
| --------------  | ---                |
| **Keys**        | {idCollection} |
| **Functional Dependencies:** |       |
| FD0101          | idCollection -> {name}  |
| **NORMAL FORM** | BCNF               |


| **TABLE R08**   | book_collection             |
| --------------  | ---                |
| **Keys**        | {idBook, idCollection} |
| **Functional Dependencies:** |       |
| none|none  |
| **NORMAL FORM** | BCNF               |

| **TABLE R09**   | category             |
| --------------  | ---                |
| **Keys**        | {idCategory} |
| **Functional Dependencies:** |       |
| FD0101          | idCategory -> {name}  |
| **NORMAL FORM** | BCNF               |

| **TABLE R10**   | review             |
| --------------  | ---                |
| **Keys**        | {idReview} |
| **Functional Dependencies:** |       |
| FD0101          | idReview -> {rating, comment, date, idBook, idUser} |
| **NORMAL FORM** | BCNF               |

| **TABLE R11**   | puchase            |
| --------------  | ---                |
| **Keys**        |  {idPurchase} |
| **Functional Dependencies:** |       |
| FD0101          | idPurchase -> {date, idUser} |
| **NORMAL FORM** | BCNF               |

| **TABLE R12**   |received            |
| --------------  | ---                |
| **Keys**        |  {idPurchase} |
| **Functional Dependencies:** |       |
| none|none  |
| **NORMAL FORM** | BCNF               |

| **TABLE R13**   | dispached           |
| --------------  | ---                |
| **Keys**        |  {idPurchase} |
| **Functional Dependencies:** |       |
| none|none  |
| **NORMAL FORM** | BCNF               |

| **TABLE R14**   | delivered          |
| --------------  | ---                |
| **Keys**        |  {idPurchase} |
| **Functional Dependencies:** |       |
| none|none  |
| **NORMAL FORM** | BCNF               |

| **TABLE R15**   | purchase_book          |
| --------------  | ---                |
| **Keys**        |  {idPurchase, idBook} |
| **Functional Dependencies:** |       |
| none|none  |
| **NORMAL FORM** | BCNF               |

| **TABLE R16**   | delivery         |
| --------------  | ---                |
| **Keys**        |  {idDelivery}, {idPurchase} |
| **Functional Dependencies:** |       |
| FD0101          | idDelivery -> {arrival, address, cost, idPurchase} |
| FD0101          | idPurchase -> {idDelivery, arrival, address, cost} |
| **NORMAL FORM** | BCNF               |

| **TABLE R17**   | book         |
| --------------  | ---                |
| **Keys**        | {idBook} |
| **Functional Dependencies:** |       |
| FD0101          | idBook -> {title, isbn, year, price, edition, idCategory, idPublisher} |
| **NORMAL FORM** | BCNF               |

| **TABLE R18**   | user         |
| --------------  | ---                |
| **Keys**        |{idUser}, {email} |
| **Functional Dependencies:** |       |
| FD0101          | idUser -> {username, email, password, address, phone} |
| FD0101          | email -> {idUser, username, password, address, phone}|
| **NORMAL FORM** | BCNF               |

| **TABLE R19**   | wishlist         |
| --------------  | ---                |
| **Keys**        | {idUser, idBook} |
| **Functional Dependencies:** |       |
| none|none  |
| **NORMAL FORM** | BCNF               |

| **TABLE R20**   | cart         |
| --------------  | ---                |
| **Keys**        | {idUser, idBook} |
| **Functional Dependencies:** |       |
| none|none  |
| **NORMAL FORM** | BCNF               |


> If necessary, description of the changes necessary to convert the schema to BCNF.  
> Justification of the BCNF.  


---


## A6: Indexes, triggers, transactions and database population

> Brief presentation of the artefact goals.

### 1. Database Workload
 
> A study of the predicted system load (database load).
> Estimate of tuples at each relation.

| **Relation reference** | **Relation Name** | **Order of magnitude**        | **Estimated growth** |
| ------------------ | ------------- | ------------------------- | -------- |
| R01                | Table1        | units|dozens|hundreds|etc | order per time |
| R02                | Table2        | units|dozens|hundreds|etc | dozens per month |
| R03                | Table3        | units|dozens|hundreds|etc | hundreds per day |
| R04                | Table4        | units|dozens|hundreds|etc | no growth |


### 2. Proposed Indices

#### 2.1. Performance Indices
 
> Indices proposed to improve performance of the identified queries.

| **Index**           | IDX01                                  |
| ---                 | ---                                    |
| **Relation**        | Relation where the index is applied    |
| **Attribute**       | Attribute where the index is applied   |
| **Type**            | B-tree, Hash, GiST or GIN              |
| **Cardinality**     | Attribute cardinality: low/medium/high |
| **Clustering**      | Clustering of the index                |
| **Justification**   | Justification for the proposed index   |
| `SQL code`                                                  ||


#### 2.2. Full-text Search Indices 

> The system being developed must provide full-text search features supported by PostgreSQL. Thus, it is necessary to specify the fields where full-text search will be available and the associated setup, namely all necessary configurations, indexes definitions and other relevant details.  

| **Index**           | IDX01                                  |
| ---                 | ---                                    |
| **Relation**        | Relation where the index is applied    |
| **Attribute**       | Attribute where the index is applied   |
| **Type**            | B-tree, Hash, GiST or GIN              |
| **Clustering**      | Clustering of the index                |
| **Justification**   | Justification for the proposed index   |
| `SQL code`                                                  ||


### 3. Triggers
 
> User-defined functions and trigger procedures that add control structures to the SQL language or perform complex computations, are identified and described to be trusted by the database server. Every kind of function (SQL functions, Stored procedures, Trigger procedures) can take base types, composite types, or combinations of these as arguments (parameters). In addition, every kind of function can return a base type or a composite type. Functions can also be defined to return sets of base or composite values.  

| **Trigger**      | TRIGGER01                              |
| ---              | ---                                    |
| **Description**  | Trigger description, including reference to the business rules involved |
| `SQL code`                                             ||

### 4. Transactions
 
> Transactions needed to assure the integrity of the data.  

| SQL Reference   | Transaction Name                    |
| --------------- | ----------------------------------- |
| Justification   | Justification for the transaction.  |
| Isolation level | Isolation level of the transaction. |
| `Complete SQL Code`                                   ||


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
