# ER: Requirements Specification Component

This is it! The book you need, the experience you want, whenever you like.

## A1: Off The Shelf

The Off The Shelf project consists in a web application that serves as an online shop made exclusively for books of all types and categories. 
This project, developed by our group, will be useful for those who are trying to buy some books online and have them delivered to their homes.
What motivates this idea are the people who want to find the perfect book to read (amongst so many that are available) and get the physical item for a real experience.  

We pretend to build a system with a practical design and a good product organization in order to help the user quickly find the ideal book with little to no effort.
The users will be able to create an account for themselves and login/logout as needed. Regarding the website administration, there's some sort of control (access and modification privileges) over user accounts and products.
This web application will also provide the users with a categorization system for the books as well as some search filters such as search by author, by year, by the publisher, etc.
The books will be displayed with pictures and their respective information. All of them contain a review section, where buyers can submit a commentary and leave a score. Users will also receive notifications, regarding order status for instance.

The platform will be used by different groups with distinct permissions. The administrators, having complete access, can add books and manage their information and manage all user accounts as well as update the orders' state. However, they cannot buy products. As for the rest of the users, the guests (non-authenticated) can browse books and categories, view reviews and other details, and also add items to a shopping cart. On the other hand, authenticated users, while being able to perform the same tasks as guests, can also view/edit their own profiles, purchase books and submit reviews. In addition to that, they have a wishlist to which they can add some of their desired books.

---

## A2: Actors and User stories

This artifact contains the specification of the actors and their user stories, serving as agile documentation of the project’s requirements.

### 1. Actors

![img](/images/actors.png)

Figure 1: Off The Shelf actors.

(table)

Table 1: Off The Shelf actors description.

### 2. User Stories

For the Off The Shelf system, consider the user stories that are presented in the following sections.

#### 2.1. User

| Identifier         | Name                                 | Priority | Description                                                                                                                          |
|--------------------|--------------------------------------|----------|--------------------------------------------------------------------------------------------------------------------------------------|
| US01 (FR.101)      | View Products List                   | high     | As a *User*, I want a products list, so that i can see the books that are available in the store.                                      |
| US02 (FR.102)      | Browse Product Categories            | high     | As a *User*, I want a filter, so that i can specify the books by category, author, year, publisher, etc.                               |
| US03 (FR.103)      | View Product Details                 | high     | As a *User*, I want to be able to see the book's details, so that i get to know more about it.                                        |
| US04 (FR.104)      | View Product Reviews                 | high     | As a *User*, I want to be able to see a book reviews, so that i have a vague idea of its quality.                                      |
| US05 (FR.105)      | Add Product to Shopping Cart         | high     | As a *User*, I want a shopping cart, so that i can add items that i might want.                                                        |
| US06 (FR.106)      | Managee Shopping Cart                | high     | As a *User*, I want a shopping cart, so that i can manage the items i wanted and decide if i want to remove any of them.               |
| US07 (FR.107)      | Search Products                      | high     | As a *User*, I want a search bar, so that i can find the desirable book.                                                               |  

Table 2: User user stories.

#### 2.2. Visitor

| Identifier | Name                       | Priority | Description                                                                                                                                         |
| ---------- | -------------------------- | -------- | --------------------------------------------------------------------------------------------------------------------------------------------------- |
| US08       | Sign In                    | high     | As a *Visitor*, I want to authenticate into the system, so that i can access a buyers or an administrators privileges.                               |
| US09       | Register                   | high     | As a *Visitor*, I want to register myself into the system, so that i can authenticate myself into the system.                                        |  

Table 3: Visitor user stories.

#### 2.3. Authenticated User

(table)

Table 4: Authenticated User user stories.

#### 2.4. Buyer

(table)

Table 5: Buyer user stories.

#### 2.4. Administrator

| Identifier         | Name                                  | Priority | Description                                                                                                                                                   |
|--------------------|---------------------------------------|----------|---------------------------------------------------------------------------------------------------------------------------------------------------------------|
| US31 (FR.601)      | Add Product                           | high     | As an *Administrator*, I want to be able to add books to the store, so that i can keep it updated with new releases.                                          |
| US32 (FR.602)      | Manage Products Information           | high     | As an *Administrator*, I want to be able to manage a products information, so that it is updated and users are not mistaken.                                  |
| US33 (FR.603)      | Manage Products Stock                 | high     | As an *Administrator*, I want to be able to manage a products stock, so that it is updated and users are not mistaken.                                        |
| US34 (FR.604)      | Manage Products Categories            | high     | As an *Administrator*, I want to be able to manage a products categories, so that it is updated and users are not mistaken.                                   |
| US35 (FR.605)      | View User's Purchase History          | high     | As an *Administrator*, I want to see a user's purchase history, so that i can see if everything is correct and they are not doing anything nefarious.         |
| US36 (FR.606)      | Manage Order Status                   | high     | As an *Administrator*, I want to be able to manage order status, so that i can keep it updated to the user.                                                   |  

Table 6: Administrator user stories.

### 3. Supplementary Requirements

This section contains business rules, technical requirements and other non-functional requirements on the project.

#### 3.1. Business rules

| Identifier | Name          | Description                                                                                                                             |
|------------|---------------|-----------------------------------------------------------------------------------------------------------------------------------------|
| BR01       | Admin         | Administrator accounts are independent of the user accounts, i.e. they cannot buy products.                                             |
| BR02       | Username      | There can't be 2 or more users with the same username.                                                                                  |
| BR03       | Book In Stock | A book can only be bought by a authenticated user if there's at least one available in stock.                                           |
| BR04       | Review Score  | Buyers need to give a score to a book in order to submit a review.                                                                      |
| BR05       | Book Info     | When looking at a specific book, the user should be able to see its author, publisher, year, price, a picture and a brief description.  |  

Table 7: Off The Shelf business rules.

#### 3.2. Technical requirements

| Identifier | Name            | Description                                                                                                                                                                                                                   |
|------------|-----------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| TR01       | Availability    | The system must be available 99 percent of the time in each 24-hour period.                                                                                                                                                   |
| TR02       | Accessibility   | The system must ensure that everyone can access the pages, regardless of whether they have any handicap or not, or the web browser they use.                                                                                  |
| **TR03**       | **Usability**       | **The system should be simple and easy to use.**                                                                                                                                                                                  |
| TR04       | Performance     | The system should have response times shorter than 2 s to ensure the user's attention.                                                                                                                                        |
| **TR05**       | **Web application** | **The system should be implemented as a web application with dynamic pages (HTML, JavaScript, CSS and PHP).**                                                                                                                     |
| TR06       | Portability     | The server-side system should work across multiple platforms (Linux, Mac OS, etc.).                                                                                                                                           |
| TR07       | Database        | The PostgreSQL database management system must be used.                                                                                                                                                                       |
| **TR08**       | **Security**        | **The system shall protect information from unauthorised access through the use of an authentication and verification system.**                                                                                                   |
| TR09       | Robustness      | The system must be prepared to handle and continue operating when runtime errors occur.                                                                                                                                       |
| TR10       | Scalability     | The system must be prepared to deal with the growth in the number of users and their actions.                                                                                                                                 |
| TR11       | Ethics          | The system must respect the ethical principles in software development (for example, personal user details, or usage data, should not be collected nor shared without full acknowledgement and authorization from its owner). |  

Table 8: Off The Shelf technical requirements.

#### 3.3. Restrictions

| Identifier | Name     | Description                                                                         |
|------------|----------|-------------------------------------------------------------------------------------|
| C01        | Deadline | The system should be ready to be used mid december.                                 |
| C02        | Workflow | Some project components must be completed until the respective planned deadlines.   |  

Table 9: Off The Shelf project restrictions.

---

## A3: Information Architecture

> Brief presentation of the artefact goals.


### 1. Sitemap

> Sitemap presenting the overall structure of the web application.  
> Each page must be identified in the sitemap.  
> Multiple instances of the same page (e.g. student profile in SIGARRA) are presented as page stacks.


### 2. Wireframes

> Wireframes for, at least, two main pages of the web application.
> Do not include trivial use cases.


#### UIxx: Page Name

#### UIxx: Page Name


---


## Revision history

Changes made to the first submission:
1. Item 1
1. ...

***
GROUP2232, DD/MM/2022

* Afonso da Silva Pinto, up202008014@fe.up.pt
* Afonso José Pinheiro Oliveira Esteves Abreu, up202008552@fe.up.pt
* Diogo Filipe Ferreira da Silva, up202004288@fe.up.pt
* Rúben Lourinha Monteiro, up202006478@fe.up.pt
