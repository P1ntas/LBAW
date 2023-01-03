# PA: Product and Presentation

This is it! The book you need, the experience you want, whenever you like.

## A9: Product

The Off The Shelf project consists in a web application that serves as an online shop made exclusively for books of all types and categories. This project, developed by our group, will be useful for those who are trying to buy some books online and have them delivered to their homes.  
The users will be able to create an account for themselves and login/logout as needed. Books are categorized and users can browse them (search and filter) and add them to their wishlists and shopping carts in order to make purchases, as well as leave some reviews.

### 1. Installation

Link to the release (final version of source code): (link)
Docker command to start the image:
```
commands
```

### 2. Usage

URL to the product: http://lbaw2232.lbaw.fe.up.pt  

#### 2.1. Administration Credentials

| Username  | Email       | Password   |
| ----------- | ----------- | ---------- |
| Diogo Silva | diogosilva@gmail.com | qwerty33  |

#### 2.2. User Credentials

| Type          | Username  | Email  | Password |
| ------------- | --------- | --------- | -------- |
| basic account | Afonso Abreu | afonsoabreu@gmail.com    | 123aaa |
| basic account | Afonso Pinto | afonsopinto@gmail.com    | 456bbb |
| basic account | Ruben Monteiro | rubenmonteiro@gmail.com    | 789ccc |

### 3. Application Help

The Off The Shelf website presents, as its main way of helping the user and clarifying some points, the FAQ page, where relevant questions about common actions are answered. 
Also, the existence of labels/placeholders in the majority of input fields aims to better specify the intent of each topic.
Additionaly, warnings about non-intended situations as well as context errors pop up to show the user that some action is not being done correctly or as it was suposed.

### 4. Input Validation

The validation of inputs' information is supported by HTML features (requirements) and mainly using validators in PHP, to check several aspects (alongside personalized error messages), as well as making some inputs fulfill regular expressions' specifications.
The passage of the csrf token alongside forms protects the web application against CSRF attacks but there was also the need to protect it, for instance, against XSS attacks which is why the functions htmlspecialchars() and strip_tags() were heavily used to clean up received data.
The implementations of policies that authorize all kinds of actions is also relevant as it prevents an user to do something he's not supposed to.

### 5. Check Accessibility and Usability

> Provide the results of accessibility and usability tests using the following checklists. Include the results as PDF files in the group's repository. Add individual links to those files here.
>
- Accessibility: 14/18 (https://git.fe.up.pt/lbaw/lbaw2223/lbaw2232/-/blob/main/docs/Checklist_de_Acessibilidade.pdf)  
- Usability: 19/28 (https://git.fe.up.pt/lbaw/lbaw2223/lbaw2232/-/blob/main/docs/Checklist_de_Usabilidade.pdf)  

### 6. HTML & CSS Validation

> Provide the results of the validation of the HTML and CSS code using the following tools. Include the results as PDF files in the group's repository. Add individual links to those files here.
>   
> HTML: https://validator.w3.org/nu/  
> CSS: https://jigsaw.w3.org/css-validator/  

### 7. Revisions to the Project

Some of the most important changes were made in the database logic. The table admins was deleted, as we decided to include a boolean attribute 'admin_perms' in table users (to indicate if the user is an admin).
A new table notifications was added in order to notify the specific users who were affected by certain actions of the admin such as changes in prices and stock updates (product availability).
A table password_resets was also added so that the email, alongside a special token, is stored during this action.

### 8. Implementation Details

#### 8.1. Libraries Used

- [Laravel](https://laravel.com/): PHP Framework for Web Artisans - used in the entirety of the web application. 

#### 8.2 User Stories

| US Identifier | Name    | Module | Priority                       | Team Members               | State  |
| ------------- | ------- | ------ | ------------------------------ | -------------------------- | ------ |
|  US01          | About US | M05 | High/Mandatory | **Rúben Monteiro**, Afonso Pinto, Afonso Abreu |  100%  |
|  US02          | Contacts | M05 | High/Mandatory | **Rúben Monteiro**, Afonso Pinto, Afonso Abreu |  100%  |
|  US03          | Main Features | M05 | High/Mandatory | **Rúben Monteiro**, Afonso Pinto, Afonso Abreu |  100%  |
|  US04          | View Products List | M02 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US05          | View Product Reviews | M03 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US06          | View Product Details | M02 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US07          | Browse Product Categories | M02 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US08          | Search Filters | M02 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US09          | Exact Match Search | M02 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US10          | Full-text Search | M02 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US11          | Search over Multiple Attributes | M02 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US12          | Search Products | M02 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US13          | Login/Logout | M01 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US14          | Registration | M01 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US15          | View Profile | M01 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US16          | Edit Profile | M01 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  90%  |
|  US17          | Delete Account | M01 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US18          | Manage Shopping Cart | M04 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US19          | Add Product to Shopping Cart | M04 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US20          | View Purchase History | M04 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US21          | Track Order | M04 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US22          | Cancel Order | M04 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US23          | Manage Wishlist | M04 | High/Mandatory | **Rúben Monteiro**, Afonso Pinto, Afonso Abreu |  100%  |
|  US24          | Add Product to Wishlist | M04 | High/Mandatory | **Rúben Monteiro**, Afonso Pinto, Afonso Abreu |  100%  |
|  US25          | Checkout | M04 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US26          | Review Product | M03 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US27          | Review Purchased Product | M03 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US28          | Remove Review | M03 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US29          | Edit Review | M03 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US30          | Administrator Accounts | M05 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US31          | Administer User Accounts | M05 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US32          | Delete User Account | M05 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US33          | View Users’ Purchase History | M05 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US34          | Block and Unblock User Accounts | M05 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US35          | Manage Order Status | M05 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US36          | Add Product | M05 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US37          | Manage Products Information | M05 | High/Mandatory | **Rúben Monteiro**, Afonso Pinto, Afonso Abreu |  90%  |
|  US38          | Manage Products Stock | M05 | High/Mandatory | **Rúben Monteiro**, Afonso Pinto, Afonso Abreu |  100%  |
|  US39          | Manage Product Categories | M05 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US40          | Contextual Help | --- | High/Mandatory | **Rúben Monteiro**, Afonso Pinto, Afonso Abreu |  10%  |
|  US41          | Placeholders in Form Inputs | --- | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US42          | Contextual Error Messages | --- | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US43          | View Personal Notifications | M01 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US44          | Payment Approved | M01 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US45          | Change in Order Processing Stage | M01 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US46          | Product on Cart Price Change | M01 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US47          | Product in Wishlist Available | M01 | High/Mandatory | **Rúben Monteiro**, Afonso Pinto, Afonso Abreu |  100%  |
|  US48          | Support Profile Picture | M01 | High/Mandatory | **Rúben Monteiro**, Afonso Pinto, Afonso Abreu |  60%  |
|  US49          | Recover Password | M01 | High/Mandatory | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  40%  |
|  US50          | Browse Collections | M04 | Low/Optional | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |
|  US51          | View Collection Products | M04 | Low/Optional | **Diogo Silva**, Afonso Pinto, Afonso Abreu |  100%  |

---

## A10: Presentation

### 1. Product presentation

The Off The Shelf project consists in a web application that serves as an online shop made exclusively for books of all types and categories. This project, developed by our group, will be useful for those who are trying to buy some books online and have them delivered to their homes.  
The users will be able to create an account for themselves and login/logout as needed. Books are categorized and users can browse them (search and filter) and add them to their wishlists and shopping carts in order to make purchases, as well as leave some reviews.

- URL to the product: http://lbaw2232.lbaw.fe.up.pt  

### 2. Video presentation

> Screenshot of the video plus the link to the lbaw2232.mp4 file  

> - Upload the lbaw21gg.mp4 file to the video uploads' [Google folder](https://drive.google.com/drive/folders/1-fPoSR3lXyPI38UgpWf6iQBe2Lk_ckoT?usp=sharing "Videos folder"). You need to use a Google U.Porto account to upload the video.   
> - The video must not exceed 2 minutes.
> - Include a link to the video on the Google Drive folder.

---

## Revision history

Changes made to the first submission:
1. Item 1
1. ..

***
GROUP2232, 03/01/2023

* Afonso da Silva Pinto, up202008014@fe.up.pt
* Afonso José Pinheiro Oliveira Esteves Abreu, up202008552@fe.up.pt
* Diogo Filipe Ferreira da Silva, up202004288@fe.up.pt
* Rúben Lourinha Monteiro, up202006478@fe.up.pt
