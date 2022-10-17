PRAGMA foreign_keys = ON;
.mode columns
.headers on
.nullvalue NULL
BEGIN TRANSACTION;

-- Table: FAQ
DROP TABLE IF EXISTS FAQ;

CREATE TABLE FAQ (
    question TEXT,
    answer TEXT,
    PRIMARY KEY (question, answer)
);

-- Table: Admins
DROP TABLE IF EXISTS Admins;

CREATE TABLE Admins (
    idAdmin INTEGER PRIMARY KEY,
    adminName TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    adminPassword TEXT NOT NULL
);

-- Table: Publisher
DROP TABLE IF EXISTS Publisher;

CREATE TABLE Publisher (
    idPublisher INTEGER PRIMARY KEY,
    publisherName TEXT NOT NULL
);

-- Table: Author
DROP TABLE IF EXISTS Author;

CREATE TABLE Author (
    idAuthor INTEGER PRIMARY KEY,
    authorName TEXT NOT NULL
);

-- Table: Collections
DROP TABLE IF EXISTS Collections;

CREATE TABLE Collections (
    idCollection INTEGER PRIMARY KEY,
    collectionName TEXT NOT NULL
);

-- Table: Category
DROP TABLE IF EXISTS Category;

CREATE TABLE Category (
    idCategory INTEGER PRIMARY KEY,
    categoryName TEXT NOT NULL
);

-- Table: User
DROP TABLE IF EXISTS User;

CREATE TABLE User (
    idUser INTEGER PRIMARY KEY,
    username TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,      
    userPassword TEXT NOT NULL,                  
    userAddress TEXT,
    phone CHAR(9)             
);

-- Table: Purchase
DROP TABLE IF EXISTS Purchase;

CREATE TABLE Purchase (
    idPurchase INTEGER PRIMARY KEY,
    purchaseDate DATE NOT NULL,
    idUser INTEGER NOT NULL REFERENCES User(idUser) ON DELETE CASCADE 
);

-- Table: Book
DROP TABLE IF EXISTS Book;

CREATE TABLE Book (
    idBook INTEGER PRIMARY KEY,
    title TEXT NOT NULL,      
    isbn INTEGER NOT NULL,
    year INTEGER,   
    price NUMERIC(9, 2) NOT NULL CHECK (price >= 0),               
    bookEdition INTEGER,
    idCategory INTEGER NOT NULL REFERENCES Category(idCategory) ON DELETE CASCADE,
    idPublisher INTEGER REFERENCES Publisher(idPublisher) ON DELETE CASCADE                         
);

-- Table: Photo
DROP TABLE IF EXISTS Photo;

CREATE TABLE Photo (
    idPhoto INTEGER PRIMARY KEY,
    photoImage TEXT NOT NULL,      
    idBook INTEGER REFERENCES Book(idBook) ON UPDATE CASCADE ON DELETE CASCADE,
    idUser INTEGER UNIQUE REFERENCES User(idUser) ON UPDATE CASCADE ON DELETE CASCADE,
    idAdmin INTEGER UNIQUE REFERENCES Admins(idAdmin) ON UPDATE CASCADE ON DELETE CASCADE           
);

-- Table: BookAuthor
DROP TABLE IF EXISTS BookAuthor;

CREATE TABLE BookAuthor (
    idBook INTEGER REFERENCES Book(idBook) ON DELETE CASCADE,
    idAuthor INTEGER REFERENCES Author(idAuthor) ON DELETE CASCADE,
    PRIMARY KEY (idBook, idAuthor)                       
);

-- Table: BookCollection
DROP TABLE IF EXISTS BookCollection;

CREATE TABLE BookCollection (
    idBook INTEGER REFERENCES Book(idBook) ON DELETE CASCADE,
    idCollection INTEGER REFERENCES Collections(idCollection) ON DELETE CASCADE,
    PRIMARY KEY (idBook, idCollection)                 
);

-- Table: Review
DROP TABLE IF EXISTS Review;

CREATE TABLE Review (
    idReview INTEGER PRIMARY KEY,
    rating NUMERIC(1, 2) NOT NULL CHECK (rating > 0 AND rating <= 5),
    comment TEXT,
    reviewDate DATE NOT NULL,
    idBook INTEGER NOT NULL REFERENCES Book(idBook) ON UPDATE CASCADE ON DELETE CASCADE,
    idUser INTEGER NOT NULL REFERENCES User(idUser) ON UPDATE CASCADE ON DELETE CASCADE          
);

-- Table: Received
DROP TABLE IF EXISTS Received;

CREATE TABLE Received (
    idPurchase INTEGER PRIMARY KEY REFERENCES Purchase(idPurchase) ON UPDATE CASCADE ON DELETE CASCADE         
);

-- Table: Dispatched
DROP TABLE IF EXISTS Dispatched;

CREATE TABLE Dispatched (
    idPurchase INTEGER PRIMARY KEY REFERENCES Purchase(idPurchase) ON UPDATE CASCADE ON DELETE CASCADE         
);

-- Table: Delivered
DROP TABLE IF EXISTS Delivered;

CREATE TABLE Delivered (
    idPurchase INTEGER PRIMARY KEY REFERENCES Purchase(idPurchase) ON UPDATE CASCADE ON DELETE CASCADE         
);

-- Table: PurchaseBook
DROP TABLE IF EXISTS PurchaseBook;

CREATE TABLE PurchaseBook (
    idPurchase INTEGER REFERENCES Purchase(idPurchase) ON DELETE CASCADE,
    idBook INTEGER REFERENCES Book(idBook) ON DELETE CASCADE,
    PRIMARY KEY (idPurchase, idBook)        
);

-- Table: Delivery
DROP TABLE IF EXISTS Delivery;

CREATE TABLE Delivery (
    idDelivery INTEGER PRIMARY KEY,
    arrival DATE NOT NULL,
    deliveryAddress TEXT NOT NULL,
    cost NUMERIC(9, 2) NOT NULL CHECK (cost >= 0),
    idPurchase INTEGER NOT NULL UNIQUE REFERENCES Purchase(idPurchase) ON UPDATE CASCADE ON DELETE CASCADE   
);

-- Table: Wishlist
DROP TABLE IF EXISTS Wishlist;

CREATE TABLE Wishlist (
    idUser INTEGER REFERENCES User(idUser) ON DELETE CASCADE,
    idBook INTEGER REFERENCES Book(idBook) ON DELETE CASCADE,
    PRIMARY KEY (idUser, idBook)        
);

-- Table: Cart
DROP TABLE IF EXISTS Cart;

CREATE TABLE Cart (
    idUser INTEGER REFERENCES User(idUser) ON DELETE CASCADE,
    idBook INTEGER REFERENCES Book(idBook) ON DELETE CASCADE,
    PRIMARY KEY (idUser, idBook)        
);

COMMIT TRANSACTION;
PRAGMA foreign_keys = on;
