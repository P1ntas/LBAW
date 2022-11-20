# EAP: Architecture Specification and Prototype

This is it! The book you need, the experience you want, whenever you like.

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
        <td>M03: Reviews</td>
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
        <td><b>PUB</b></td>
        <td>Public</td>
        <td>Users without any privileges.</td>
    </tr>
    <tr>
        <td><b>USR</b></td>
        <td>User</td>
        <td>Authenticated users.</td>
    </tr>
    <tr>
        <td><b>BYR</b></td>
        <td>Buyer</td>
        <td>Group of users that can update their profiles and have privileges regarding their purchases and reviews, as well as books added to their wishlists and carts.</td>
    </tr>
    <tr>
        <td><b>ADM</b></td>
        <td>Administrator</td>
        <td>System administrators, able to edit both products, users and system related information.</td>
    </tr>
</table>

### 3. OpenAPI Specification

OpenAPI specification in YAML format to describe the web application's web resources.

Link to the `a7_openapi.yaml` file in the group's repository: https://git.fe.up.pt/lbaw/lbaw2223/lbaw2232/-/blob/main/docs/a7_openapi.yaml


```yaml
openapi: 3.0.0

info:
  version: '1.0'
  title: 'LBAW Off The Shelf Web API'
  description: 'Web Resources Specification (A7) for Off The Shelf'

servers:
- url: http://lbaw.fe.up.pt
  description: Production server

externalDocs:
  description: Find more info here.
  url: https://git.fe.up.pt/lbaw/lbaw2223/lbaw2232/-/tree/main/

tags:
  - name: 'M01: Authentication and Profile'
  - name: 'M02: Products and Categories'
  - name: 'M03: Reviews'
  - name: 'M04: Cart, Wishlist and Collections'
  - name: 'M05: Administration and Static Pages'

paths:
 /login:
   get:
     operationId: R101
     summary: 'R101: Login Form'
     description: 'Provide login form. Access: PUB'
     tags:
       - 'M01: Authentication and Profile'
     responses:
       '200':
         description: 'Ok. Show Log-in UI'
       '302':
          description: 'Redirect if user is logged in.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Authenticated. Redirecting to user dashboard.'
                  value: '/dashboard'
   post:
     operationId: R102
     summary: 'R102: Login Action'
     description: 'Processes the login form submission. Access: PUB'
     tags:
       - 'M01: Authentication and Profile'

     requestBody:
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: object
             properties:
               email:          # <!--- form field name
                 type: string
               password:    # <!--- form field name
                 type: string
             required:
                  - email
                  - password
     responses:
       '302':
         description: 'Redirect after processing the login credentials.'
         headers:
           Location:
             schema:
               type: string
             examples:
               302Success:
                 description: 'Successful authentication. Redirect to user profile.'
                 value: '/users/{id}'
               302Error:
                 description: 'Failed authentication. Redirect to login form.'
                 value: '/login'

 /logout:

   post:
     operationId: R103
     summary: 'R103: Logout Action'
     description: 'Logout the current authenticated user. Access: USR, ADM'
     tags:
       - 'M01: Authentication and Profile'
     responses:
       '302':
         description: 'Redirect after processing logout.'
         headers:
           Location:
             schema:
               type: string
             examples:
               302Success:
                 description: 'Successful logout. Redirect to login form.'
                 value: '/login'


 /register:

    get:
      operationId: R104
      summary: 'R104: Register Form'
      description: 'Provide new user registration form. Access: PUB'
      tags:
        - 'M01: Authentication and Profile'
      responses:
        '200':
          description: 'Ok. Show Sign-Up UI'
        '302':
            description: 'Redirect if user is logged in.'
            headers:
              Location:
                schema:
                  type: string
                examples:
                  302Success:
                    description: 'Authenticated. Redirect to user dashboard.'
                    value: '/dashboard'
    post:
     operationId: R105
     summary: 'R105: Register Action'
     description: 'Processes the new user registration form submission. Access: PUB'
     tags:
       - 'M01: Authentication and Individual Profile'

     requestBody:
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: object
             properties:
               name:
                 type: string
               email:
                 type: string
               picture:
                 type: string
                 format: binary
             required:
                  - email
                  - password

     responses:
       '302':
         description: 'Redirect after processing the new user information.'
         headers:
           Location:
             schema:
               type: string
             examples:
               302Success:
                 description: 'Successful authentication. Redirect to user profile.'
                 value: '/users/{id}'
               302Failure:
                 description: 'Failed authentication. Redirect to register form.'
                 value: '/register'
                
 /users/{id}:
   get:
     operationId: R106
     summary: 'R106: View user profile'
     description: 'Show the individual user profile. Access: USR'
     tags:
       - 'M01: Authentication and Profile'

     parameters:
       - in: path
         name: id
         schema:
           type: integer
         required: true

     responses:
       '200':
         description: 'Ok. Show User Profile UI'
       '404':
          description: 'Not Found. Show 404 message'

   patch:
      operationId: R107
      summary: 'R107: Edit Profile'
      description: 'Edit account information. Access: ACO'
      tags:
        - 'M01: Authentication and Profile'

      parameters:
        - in: path
          name: email
          schema:
            type: string
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                username:
                  type: string
                user_password:
                  type: string
                user_address:
                  type: string
                phone:
                  type: integer

      responses:
        '200':
          description: 'Successful'
        "401":
          description: "Unauthorized"

   delete:
      operationId: R108
      summary: 'R108: Delete Account'
      description: 'Delete account. Access: ACO, ADM'
      tags:
        - 'M01: Authentication and Profile'

      parameters:
        - in: path
          name: email
          schema:
            type: string
          required: true

      responses:
        '200':
          description: 'Successful'

 /settings:
    get:
      operationId: R109
      summary: 'R109: View Account Settings'
      description: 'Show account settings page. Access: ACO'
      tags:
        - 'M01: Authentication and Profile'

      responses:
        '200':
          description: 'Successful'
        "401":
          description: "Unauthorized"

    patch:
      operationId: R110
      summary: 'R110: Edit Account Settings. Access: ACO'
      description: 'Edit account settings'
      tags:
        - 'M01: Authentication and Profile'

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                allowNoti:
                  type: boolean
                commentNoti:
                  type: boolean
                PurchaseCompleted:
                  type: boolean
                Username:
                  type: string
                Email:
                  type: string
                Adress:
                  type: string
                Phone:
                  type: integer
                Password:
                  type: string
                blocked:
                  type: boolean

      responses:
        '200':
          description: 'Successful'
        "401":
          description: "Unauthorized"


 /avatars/{img}:
   get:
      operationId: R111
      summary: 'R111: Get Avatar'
      description: 'Get avatar image from local storage. Access: USR'
      tags:
        - 'M01: Authentication and Profile'

      parameters:
        - in: path
          name: img
          schema:
            type: string
          required: true

      responses:
        '200':
          description: 'Ok'
        "404":
          description: "Not Found" 

 /api/productsAndCategories:
   get:
     operationId: R201
     summary: 'R201: Search Products and Categories API'
     description: 'Searches for products or categories and returns the results as JSON. Access: PUB.'

     tags: 
       - 'M02: Products and Categories'

     parameters:
       - in: query
         name: query
         description: String to use for full-text search
         schema:
           type: string
         required: false
       - in: query
         name: item
         description: Name of the product
         schema:
           type: string
         required: false
       - in: query
         name: category
         description: Category of the product
         schema:
           type: string
         required: false
       - in: query
         name: loaned
         description: Boolean with the loaned flag value
         schema:
           type: boolean
         required: false
       - in: query
         name: classification
         description: Integer corresponding to the work classification
         schema:
           type: integer
         required: false

     responses:
       '200':
         description: Success
         content:
           application/json:
             schema:
               type: array
               items:
                $ref: '#'

       '400':
          description: "Bad Request"

   post:
      operationId: R202
      summary: 'R202: Create Product'
      description: 'Processes the product creation . Access: ADM'
      tags:
        - 'M02: Products and Categories'

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                   id_book:
                     type: integer
                   title:
                     type: string
                   year:
                     type: integer
                   price:
                     type: number
                   book_description:
                     type: string
                   type:
                     type: string
                   publisher:
                     type: string
              required:
                - id_book
                - title
                - year
                - type
                - publisher
      
      responses:
        '302':
          description: 'Redirect after processing the new product information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful creation. Redirect to product overview.'
                  value: '/product/{id}/overview'
                302Failure:
                  description: 'Failed creation. Redirect to user dashboard.'
                  value: '/dashboard'

 /api/productsAndCategories/{id}:
    get:
      operationId: R203
      summary: 'R203: Get Product Information'
      description: "Get product information as JSON. Access: RDR"
      tags:
        - 'M02: Products and Categories'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      responses:
        '200':
          description: Success
          content:
            application/json:
              schema:
                type: object
                properties:
                   id_book:
                     type: integer
                   title:
                     type: string
                   year:
                     type: integer
                   price:
                     type: number
                   book_description:
                     type: string
                   type:
                     type: string
                   publisher:
                     type: string
                required:
                - id_book
                - title
                - year
                - type
                - publisher
        "403":
          description: Forbidden
        "404":
          description: Not Found

    delete:
      operationId: R204
      summary: 'R204: Delete Product'
      description: 'Delete a product. Access: RDR'
      tags:
        - 'M02: Products and Categories'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      responses:
        '302':
          description: 'Redirect after processing the deletion request.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful. Redirect to user dashboard.'
                  value: '/dashboard'
                302Failure:
                  description: 'Failed. Redirect to user dashboard.'
                  value: '/dashboard'
        "400":
          description: "Bad Request. Must have at least one owner in the project"
        "403":
          description: Forbidden
        "404":
          description: Not Found

    patch:
      operationId: R205
      summary: 'R205: Update Product'
      description: 'Processes the product attributes. Access: OWN'
      tags:
        - 'M02: Products'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                   id_book:
                     type: integer
                   title:
                     type: string
                   year:
                     type: integer
                   price:
                     type: number
                   book_description:
                     type: string
                   type:
                     type: string
                   publisher:
                     type: string

      responses:
        "200":
          description: Success
        "403":
          description: Forbidden
        "404":
          description: Not Found

 /api/productsAndCategories/{id}/book:
    get:
      operationId: R206
      summary: "R206: Search Books"
      description: "Searches for books and returns the results as JSON. Access: RDR"
      tags:
        - 'M02: Products and Categories'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
        - in: query
          name: query
          description: String to use for full-text search
          schema:
            type: string
          required: false
        - in: query
          name: category
          description: Category of the tasks
          schema:
            type: string
          required: false
        - in: query
          name: status
          description: Status of the tasks
          schema:
            type: string
            enum: ['Waiting', 'Not Started', 'In Progress', 'Completed']
          required: false

      responses:
        '200':
          description: Success
          content:
            application/json:
              schema:
                type: array
                items:
                  $ref: '#'
        '400':
          description: Bad Request
        "403":
          description: Forbidden
        "404":
          description: Not Found

    post:
      operationId: R207
      summary: 'R207: Create Book'
      description: 'Processes the task creation form submission. Access: EDT'
      tags:
        - 'M02: Products and Categories'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                   id_book:
                     type: integer
                   title:
                     type: string
                   year:
                     type: integer
                   price:
                     type: number
                   book_description:
                     type: string
                   type:
                     type: string
                   publisher:
                     type: string

      responses:
        '302':
          description: 'Redirect after processing the new task information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful creation. Redirect to task card.'
                  value: '/project/{id}/overview'
                302Failure:
                  description: 'Failed creation. Redirect to project dashboard.'
                  value: '/project/{id}/overview'
        '400':
          description: Bad Request
        "403":
          description: Forbidden
        "404":
          description: Not Found

 /api/productsAndCategories/{id}/book/{book}/category:
    post:
      operationId: R208
      summary: 'R208: Add a category'
      description: 'Add a category to a task. Access: EDT'
      tags:
        - 'M02: Products and Categories'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
        - in: path
          name: query
          schema:
            type: string
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                tag:
                  type: integer
              required:
                - tag

      responses:
        "200":
          description: "OK"
        "403":
          description: "Forbidden access"
        "404":
          description: "Tag not found"
    
    delete:
      operationId: R209
      summary: 'R209: Delete Category'
      description: 'Delete a category. Access: RDR'
      tags:
        - 'M02: Products and Categories'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      responses:
        '302':
          description: 'Redirect after processing the deletion request.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful. Redirect to user dashboard.'
                  value: '/dashboard'
                302Failure:
                  description: 'Failed. Redirect to user dashboard.'
                  value: '/dashboard'
        "400":
          description: "Bad Request. Must have at least one owner in the project"
        "403":
          description: Forbidden
        "404":
          description: Not Found

    patch:
      operationId: R210
      summary: 'R210: Update Category'
      description: 'Processes the category attributes. Access: OWN'
      tags:
        - 'M02: Products and Categories'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                tag:
                  type: integer
              required:
                - tag

      responses:
        "200":
          description: Success
        "403":
          description: Forbidden
        "404":
          description: Not Found

 /api/productsAndCategories/{id}/book/{task}/comment:
    post:
      operationId: R210
      summary: 'R210: Add a comment'
      description: 'Add a comment to a book. Access: RDR'
      tags:
        - 'M02: Products and Categories'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
        - in: path
          name: task
          schema:
            type: integer
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                comment:
                  type: string
                parent:
                  type: integer
              required:
                - comment

      responses:
        "200":
          description: "OK"
        "403":
          description: "Forbidden access"
        "404":
          description: "Tag not found"
 
    delete:
      operationId: R211
      summary: 'R211: Delete a comment'
      description: 'Delete a comment. Access: RDR'
      tags:
        - 'M02: Products and Categories'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      responses:
        '302':
          description: 'Redirect after processing the deletion request.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful. Redirect to user dashboard.'
                  value: '/dashboard'
                302Failure:
                  description: 'Failed. Redirect to user dashboard.'
                  value: '/dashboard'
        "400":
          description: "Bad Request. Must have at least one owner in the project"
        "403":
          description: Forbidden
        "404":
          description: Not Found

    patch:
      operationId: R212
      summary: 'R212: Update Comment'
      description: 'Processes the comment changes. Access: OWN'
      tags:
        - 'M02: Products and Categories'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                tag:
                  type: integer
              required:
                - tag

      responses:
        "200":
          description: Success
        "403":
          description: Forbidden
        "404":
          description: Not Found

 /api/productsAndCategories/{id}/book/{task}/review:
    post:
      operationId: R301
      summary: 'R301: Add a review'
      description: 'Add a review to a book. Access: RDR'
      tags:
        - 'M03: Reviews'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
        - in: path
          name: task
          schema:
            type: integer
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                comment:
                  type: string
                parent:
                  type: integer
              required:
                - comment

      responses:
        "200":
          description: "OK"
        "403":
          description: "Forbidden access"
        "404":
          description: "Tag not found"
    
    delete:
      operationId: R302
      summary: 'R302: Delete Review'
      description: 'Delete a review. Access: RDR'
      tags:
        - 'M03: Reviews'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      responses:
        '302':
          description: 'Redirect after processing the deletion request.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful. Redirect to user dashboard.'
                  value: '/dashboard'
                302Failure:
                  description: 'Failed. Redirect to user dashboard.'
                  value: '/dashboard'
        "400":
          description: "Bad Request. Must have at least one owner in the project"
        "403":
          description: Forbidden
        "404":
          description: Not Found

    patch:
      operationId: R303
      summary: 'R303: Update Review'
      description: 'Processes the review changes. Access: OWN'
      tags:
        - 'M03: Reviews'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                comment:
                  type: string
                parent:
                  type: integer
              required:
                - comment

      responses:
        "200":
          description: Success
        "403":
          description: Forbidden
        "404":
          description: Not Found


 /api/CartWishlistAndCollections/Cart:
   patch:
      operationId: R401
      summary: "R401: Update cart"
      description: "Update books in a user's cart. Access: USR"
      tags:
        - 'M04: Cart, Wishlist and Collections'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                id_user: 
                  type: integer
                id_book:
                  type: integer
              required:
                - id_user
                - id_book

      responses:
        "200":
          description: Success
        "404":
          description: Not Found
      


 /api/CartWishlistAndCollections/whislist:
   patch:
      operationId: R402
      summary: "R402: Update whislist"
      description: "Update books in a user's whislist. Access: USR"
      tags:
        - 'M04: Cart, Wishlist and Collections'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                id_user: 
                  type: integer
                id_book:
                  type: integer
              required:
                - id_user
                - id_book

      responses:
        "200":
          description: Success
        "404":
          description: Not Found


 /api/CartWishlistAndCollections/Collections:
   get:
      operationId: R403
      summary: 'R404: Get collection'
      description: 'Get the collection of a book. Access: USR, ADM'
      tags:
        - 'M04: Cart, Wishlist and Collections'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      responses:
        '200':
          description: Success
          content:
            application/json:
              schema:
                type: object
                properties:
                   id_book:
                    type: integer
                   id_collection:
                    type: integer
                required:
                  - id_collection

        "403":
          description: Forbidden
        "404":
          description: Not Found

   post:
      operationId: R404
      summary: 'R404: Add a collection'
      description: 'Add a collection to a book. Access: ADM'
      tags:
        - 'M04: Cart, Wishlist and Collections'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
        - in: path
          name: task
          schema:
            type: integer
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                id_book:
                  type: integer
                id_collection:
                  type: integer
              required:
                - id_book
                - id_collection
      responses:
        "200":
          description: "OK"
        "403":
          description: "Forbidden access"
        "404":
          description: "Tag not found"

   delete:
      operationId: R405
      summary: 'R302: Delete collection'
      description: 'Delete a collection from a book. Access: ADM'
      tags:
        - 'M04: Cart, Wishlist and Collections'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      responses:
        '302':
          description: 'Redirect after processing the deletion request.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful. Redirect to user dashboard.'
                  value: '/dashboard'
                302Failure:
                  description: 'Failed. Redirect to user dashboard.'
                  value: '/dashboard'
        "400":
          description: "Bad Request. Must have at least one owner in the project"
        "403":
          description: Forbidden
        "404":
          description: Not Found

   patch:
      operationId: R403
      summary: "R403: Update collection"
      description: "Update callection of given book. Access: ADM"
      tags:
        - 'M04: Cart, Wishlist and Collections'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                id_book: 
                  type: integer
                id_collection:
                  type: integer
              required:
                - id_book
                - id_collection

      responses:
        "200":
          description: Success
        "404":
          description: Not Found

 /faqs:
    get:
      operationId: R501
      summary: 'R501: View Faqs Page'
      description: "View Frequently Asked Questions page. Access: PUB"
      tags:
        - 'M05: Administration and Static Pages'

      responses:
        '200':
          description: 'OK. Show '

 /admin/users:
    get:
      operationId: R502
      summary: 'R502: View User Management page'
      description: "View user management page. Access: ADM"
      tags:
        - 'M05: Administration and Static pages'

      responses:
        '200':
          description: 'OK. Show [UI17](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2134/-/wikis/ER#ui17-admin-manage-users)'
        "403":
          description: "Forbidden access"


 /api/AdmnistrationAndStaticPages:
    get:
      operationId: R503
      summary: "R503: Search User API"
      description: "Searches for users and returns the results as JSON. Access: ADM"
      tags:
        - 'M05: Administration and Static Pages'

      parameters:
        - in: query
          name: query
          description: String to use for full-text search
          schema:
            type: string
          required: false

      responses:
        '200':
          description: Success
          content:
            application/json:
              schema:
                type: array
                items:
                   $ref: '#'
        '400':
          description: Bad Request
  
components:
  schemas:
    User:
      type: object
      properties:
        id:
          type: integer
        name:
          type: string
        picture:
          type: string
          format: binary

    Product:
      type: object
      properties:
        id_book:
          type: integer
        title:
          type: string
        year:
          type: integer
        price:
          type: number
        book_description:
          type: string
        publisher:
          type: string

    TaskSummary:
      type: object
      properties:
        id:
          type: integer
        name:
          type: string
        status:
          type: string
          enum: ['Received', 'Dispatched', 'Delivered']

    CheckListItem:
      type: object
      properties:
        name:
          type: string
        completed:
          type: boolean

    Comment:
      type: object
      properties:
        id:
          type: integer
        author:
          $ref: '#'
        comment_date:
          type: string
        comment_text:
          type: string
        parent:
          type: integer
```

---

## A8: Vertical prototype

The Vertical Prototype includes the implementation of the features marked as necessary (with an asterisk) in the common and theme requirements documents. This artifact aims to validate the architecture presented, also serving to gain familiarity with the technologies used in the project.

### 1. Implemented Features

#### 1.1. Implemented User Stories

The user stories that were implemented in the prototype are described in the following table.

| User Story reference | Name                   | Priority                   | Description                   |
| -------------------- | ---------------------- | -------------------------- | ----------------------------- |
| US01               | View Products List                   | high     | As a *User*, I want a products list, so that I can see the books that are available in the store.                                    |
| US03               | View Product Details                 | high     | As a *User*, I want to be able to see the book's details, so that I get to know more about it.                                       |
| US04               | View Product Reviews                 | high     | As a *User*, I want to be able to see a book reviews, so that I have a vague idea of its quality.                                    |
| US05               | Add Product to Shopping Cart         | high     | As a *User*, I want a shopping cart, so that I can add items that I might want.                                                      |
| US06               | Manage Shopping Cart                 | high     | As a *User*, I want a shopping cart, so that I can manage the items I wanted and decide if I want to remove any of them.             |
| US07               | Search Products                      | high     | As a *User*, I want a search bar, so that I can find the desirable book.                                                             |
| US09       | Sign In                    | high     | As a *Visitor*, I want to authenticate into the system, so that I can access an administrator/authenticated user's privileges.                     |
| US10       | Register                   | high     | As a *Visitor*, I want to register myself into the system, so that I can authenticate myself into the system.                                      |  
| US11               | View Purchase History                  | high     | As an *Authenticated User*, I want a purchase history, so that I can track my purchases along the way.                                                      |
| US15               | Checkout                               | high     | As an *Authenticated User*, I want to be able to checkout my shopping cart, so that I can get the products I want.                                          |
| US18               | Logout                                 | high     | As an *Authenticated User*, I want to be able to logout, so that I can end my user session at the moment.                                                   |
| US32               | Administer User Accounts              | high     | As an *Administrator*, I want to administrate user accounts, so that I can have some control over them and keep the system clean.                             |
| US33               | Block/Unblock Users                   | high     | As an *Administrator*, I want to block or unblock user accounts, so that the system stays healthy and the users notice some kind of authority.                |

...

#### 1.2. Implemented Web Resources

The web resources that were implemented in the prototype are described in the next section.

M01: Authentication and Profile

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R101: Login Form | GET /login |
| R102: Login Action | POST /login |
| R103: Logout Action | GET /logout |
| R104: Register Form | GET /register |
| R105: Register Action | POST /register |
| R106: View User Profile | GET /users/{id} |
| R107: Edit Profile Form | GET /users/{id}/edit |
| R112: Edit Profile Action | POST /users/{id}/edit |

...

M02: Products and Categories

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R203: Get Product Information | GET /books/{id} |
| R206: Search Book | POST /books/search |
| R213: View Books List | GET /books |
| R214: Add Product To Cart | POST /books/{id} |

...

M04: Cart, Wishlist and Collections

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R407: View Cart | GET /users/{id}/cart |
| R408: Remove Product From Cart | POST /users/{id}/cart |
| R409: Clear Cart | GET /users/{id}/cart/clear |
| R410: Checkout Details | GET /users/{id}/cart/checkout |
| R411: Checkout Action | POST /users/{id}/cart/checkout |
| R412: View Purchase History | GET /users/{id}/purchases |

...

M05: Administration and Static Pages

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R502: View User Management Page | GET /users |
| R503: Search User API | POST /users/search |
| R504: View Admin Profile | GET /admins/{id} |
| R505: Edit Admin Form | GET /admins/{id}/edit |
| R506: Edit Admin Action | POST /admins/{id}/edit |
| R507: View Home Page | GET / |

...

### 2. Prototype

The prototype is available at https://lbaw2232.lbaw.fe.up.pt  
- There were issues regarding the process of publishing our image since the **docker login git.fe.up.pt:5050** command was not working.

Credentials:
- admin user: 1234
- regular user: 1234

The code is available at
https://git.fe.up.pt/lbaw/lbaw2223/lbaw2232/-/tree/main/webapp

---

## Revision history

Changes made to the first submission:
1. Item 1
1. ..

***
GROUP2232, 20/11/2022
 
* Afonso da Silva Pinto, up202008014@fe.up.pt
* Afonso José Pinheiro Oliveira Esteves Abreu, up202008552@fe.up.pt
* Diogo Filipe Ferreira da Silva, up202004288@fe.up.pt
* Rúben Lourinha Monteiro, up202006478@fe.up.pt
