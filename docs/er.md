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

![img]()

Figure 1: Off The Shelf actors.

| Identifier           | Description                                                                                                                                                                                       |
|----------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| User                 | Generic user that has access to public information, such as published titles, and can search products and manage a shopping cart                                                                  |
| Visitor              | Unauthenticated user that can register themself or sign-in in the system                                                                                                                          |
| Buyer                | Authenticated user that can consult information, checkout a shopping cart, manage a wishlist, view purchase history and review a product                                                          |
| Administrator        | Authenticated user that is responsible for the management of normal users, products information, stock and categorization, along with managing orders' status. This user cannot purchase products |

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

#### 2.N. Actor n


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

Table n: Off The Shelf business rules.

#### 3.2. Technical requirements

#### 3.3. Restrictions


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
