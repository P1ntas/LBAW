# EAP: Architecture Specification and Prototype

> Project vision.

# A7: Web Resources Documentation

This artifact documents the  architecture of the web application to be developed, indicating the catalog of resources, the properties of each resource, and the format of JSON responses. This specification adheres to the OpenAPI standard using YAML.

## 1. Overview

An overview of the web application to implement is presented in this section, where the modules are identified and briefly described. The web resources associated with each module are detailed in the individual documentation of each module inside the OpenAPI specification.

<table>
    <tr>
        <td>M01: Authentication and Profile</td>
        <td> Web resources associated with the user authentication and management. Includes features such as user information (and being able to edit it), registration and login/logout actions.</td>
    </tr>
    <tr>
        <td>M02: Products and Categories</td>
        <td>Web resources associated with the search, filtering and listing of the products available to the user. For administrator profiles, you'll also be able to edit and/or delete these items.</td>
    </tr>
    <tr>
        <td>M03: Reviews, cart and Wishlist</td>
        <td>Web resources associated with product's reviews. Users will be able to add, edit and remove reviews. If a user's profile gets deleted, the review will still be viewable with the <b>[Deleted]</b> tag instead of the username.</td>
    </tr>
    <td>M04: Cart, Wishlist and Collections</td>
        <td>Web resources associated with product's attributes aggregations, such as cart and wishlist. Users will be able to add and remove products from their wishlist. If a book is no longer in the database, it will just disappear from the wishlist. The cart and the collections will have the same behaviour as the wishlist, with the exception of latter being only editable by administrators.</td>
    </tr>
    <tr>
        <td>M05: Administration and Static Pages</td>
        <td>Web resources associated with static content, such as: about, contact and faq. The administrator will not only be able to edit these pages, but will also manage users and products, as well as their respective information</td>
    </tr>
</table>

## 2. Permissions

This section defines the permissions used in the modules to establish the conditions of access to resources.

<table>
    <tr>
        <td>PUB</td>
        <td>Public</td>
        <td>Group of users without privileges.</td>
    </tr>
    <tr>
        <td>USR</td>
        <td>User</td>
        <td>Authenticated user.</td>
    </tr>
    <tr>
        <td>OWN</td>
        <td>Owner</td>
        <td>Group of users that can update their profiles and have privileges regarding their purchases and reviews.</td>
    </tr>
    <tr>
        <td>ADM</td>
        <td>Administrator</td>
        <td>Group of administrators.</td>
    </tr>
</table>

### 3. OpenAPI Specification

OpenAPI specification in YAML format to describe the web application's web resources.

Link to the `a7_openapi.yaml` file in the group's repository.


```yaml
openapi: 3.0.0

...
```

---


## A8: Vertical prototype

> Brief presentation of the artefact goals.

### 1. Implemented Features

#### 1.1. Implemented User Stories

> Identify the user stories that were implemented in the prototype.  

| User Story reference | Name                   | Priority                   | Description                   |
| -------------------- | ---------------------- | -------------------------- | ----------------------------- |
| US01                 | Name of the user story | Priority of the user story | Description of the user story |

...

#### 1.2. Implemented Web Resources

> Identify the web resources that were implemented in the prototype.  

> Module M01: Module Name  

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R01: Web resource name | URL to access the web resource |

...

> Module M02: Module Name  

...

### 2. Prototype

> URL of the prototype plus user credentials necessary to test all features.  
> Link to the prototype source code in the group's git repository.  


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
