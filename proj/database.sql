-----------------------------------------
--
-- Use this code to drop and create a schema.
-- In this case, the DROP TABLE statements can be removed.
--
-- DROP SCHEMA lbaw2232 CASCADE;
-- CREATE SCHEMA lbaw2232;
-- SET search_path TO lbaw2232;
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
    isbn INTEGER NOT NULL UNIQUE,
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


/*
Populate Tables
*/

/*Faq*/
/*(question, answer)*/
/*20*/
INSERT INTO offtheshelf.faq(question, answer) VALUES ('Nulla facilisi. Sed neque. Sed eget lacus. Mauris non dui nec urna suscipit nonummy. Fusce fermentum fermentum arcu. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae Phasellus ornare. Fusce'                                                    , 'natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin vel nisl. Quisque fringilla euismod enim. Etiam');
INSERT INTO offtheshelf.faq(question, answer) VALUES ('commodo hendrerit. Donec porttitor tellus non magna. Nam ligula elit, pretium et, rutrum non, hendrerit id, ante. Nunc mauris sapien, cursus in, hendrerit consectetuer, cursus et, magna. Praesent interdum ligula eu'                                                                 , 'a felis ullamcorper viverra. Maecenas iaculis aliquet diam. Sed diam lorem, auctor quis, tristique ac, eleifend vitae, erat. Vivamus nisi. Mauris nulla. Integer urna. Vivamus molestie dapibus ligula. Aliquam erat volutpat. Nulla dignissim. Maecenas ornare egestas ligula. Nullam feugiat placerat velit. Quisque varius. Nam');
INSERT INTO offtheshelf.faq(question, answer) VALUES ('sed pede nec ante blandit viverra. Donec tempus, lorem fringilla ornare placerat, orci lacus vestibulum lorem, sit amet ultricies sem magna nec quam. Curabitur vel lectus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus'                           , 'Duis volutpat nunc sit amet metus. Aliquam erat volutpat. Nulla facilisis. Suspendisse commodo tincidunt nibh. Phasellus nulla. Integer vulputate, risus a ultricies adipiscing, enim mi tempor lorem, eget');
INSERT INTO offtheshelf.faq(question, answer) VALUES ('Proin mi. Aliquam gravida mauris ut mi. Duis risus odio, auctor vitae, aliquet nec, imperdiet nec, leo. Morbi neque tellus, imperdiet non, vestibulum nec, euismod in, dolor. Fusce feugiat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam auctor, velit eget'      , 'velit eu sem. Pellentesque ut ipsum ac mi eleifend egestas. Sed pharetra, felis eget varius ultrices, mauris ipsum porta elit, a feugiat tellus lorem eu metus. In lorem. Donec elementum, lorem');
INSERT INTO offtheshelf.faq(question, answer) VALUES ('eget metus. In nec orci. Donec nibh. Quisque nonummy ipsum non arcu. Vivamus sit amet risus. Donec egestas.'                                                                                                                                                                            , 'nostra, per inceptos hymenaeos. Mauris ut quam vel sapien imperdiet ornare. In faucibus. Morbi vehicula. Pellentesque tincidunt tempus risus. Donec egestas. Duis ac arcu. Nunc mauris. Morbi non sapien molestie orci tincidunt adipiscing. Mauris molestie');
INSERT INTO offtheshelf.faq(question, answer) VALUES ('dignissim tempor arcu. Vestibulum ut eros non enim commodo hendrerit. Donec porttitor tellus non magna. Nam ligula elit, pretium et, rutrum non, hendrerit'                                                                                                                             , 'Nulla facilisis. Suspendisse commodo tincidunt nibh. Phasellus nulla. Integer vulputate, risus a ultricies adipiscing, enim mi tempor lorem, eget mollis lectus pede et risus. Quisque libero lacus, varius et, euismod et, commodo at, libero. Morbi accumsan laoreet ipsum.');
INSERT INTO offtheshelf.faq(question, answer) VALUES ('sapien molestie orci tincidunt adipiscing. Mauris molestie pharetra nibh. Aliquam ornare, libero at auctor ullamcorper, nisl arcu iaculis enim, sit amet ornare lectus justo eu'                                                                                                        , 'dis parturient montes, nascetur ridiculus mus. Proin vel arcu eu odio tristique pharetra. Quisque ac libero nec ligula consectetuer rhoncus. Nullam velit dui, semper et,');
INSERT INTO offtheshelf.faq(question, answer) VALUES ('scelerisque neque sed sem egestas blandit. Nam nulla magna, malesuada vel, convallis in, cursus et, eros. Proin ultrices. Duis volutpat nunc'                                                                                                                                           , 'sagittis augue, eu tempor erat neque non quam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam fringilla cursus purus. Nullam scelerisque neque sed sem egestas blandit. Nam nulla magna, malesuada vel, convallis in,');
INSERT INTO offtheshelf.faq(question, answer) VALUES ('Nam porttitor scelerisque neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu turpis. Nulla aliquet. Proin velit. Sed malesuada augue ut lacus. Nulla tincidunt, neque vitae semper'                                                                                        , 'lacus. Ut nec urna et arcu imperdiet ullamcorper. Duis at lacus. Quisque purus sapien, gravida non, sollicitudin a, malesuada id, erat. Etiam vestibulum massa rutrum magna. Cras convallis');
INSERT INTO offtheshelf.faq(question, answer) VALUES ('ligula tortor, dictum eu, placerat eget, venenatis a, magna. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam laoreet, libero et tristique'                                                                                                                              , 'pede. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin vel arcu eu odio tristique pharetra. Quisque');
INSERT INTO offtheshelf.faq(question, answer) VALUES ('dui, nec tempus mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae diam. Proin dolor. Nulla semper tellus id nunc interdum feugiat. Sed nec metus facilisis lorem tristique aliquet. Phasellus fermentum convallis ligula. Donec luctus aliquet'                                , 'arcu. Sed et libero. Proin mi. Aliquam gravida mauris ut mi. Duis risus');
INSERT INTO offtheshelf.faq(question, answer) VALUES ('sed, hendrerit a, arcu. Sed et libero. Proin mi. Aliquam gravida mauris ut mi. Duis risus odio, auctor vitae, aliquet nec, imperdiet nec, leo. Morbi neque tellus, imperdiet non, vestibulum nec, euismod in, dolor. Fusce feugiat. Lorem ipsum dolor sit amet, consectetuer adipiscing', 'massa. Mauris vestibulum, neque sed dictum eleifend, nunc risus varius orci,');
INSERT INTO offtheshelf.faq(question, answer) VALUES ('blandit enim consequat purus. Maecenas libero est, congue a, aliquet vel, vulputate eu, odio. Phasellus at augue id ante dictum cursus. Nunc'                                                                                                                                           , 'rutrum, justo. Praesent luctus. Curabitur egestas nunc sed libero. Proin sed turpis nec mauris blandit mattis. Cras eget nisi dictum augue malesuada malesuada. Integer id magna et ipsum cursus vestibulum. Mauris magna. Duis dignissim tempor arcu. Vestibulum ut eros non enim commodo');
INSERT INTO offtheshelf.faq(question, answer) VALUES ('Vivamus molestie dapibus ligula. Aliquam erat volutpat. Nulla dignissim. Maecenas ornare egestas ligula. Nullam feugiat placerat velit. Quisque varius. Nam porttitor scelerisque neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu turpis. Nulla aliquet.'               , 'dui, in sodales elit erat vitae risus. Duis a mi fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus, at fringilla purus mauris a nunc. In at pede.');
INSERT INTO offtheshelf.faq(question, answer) VALUES ('elit, pretium et, rutrum non, hendrerit id, ante. Nunc mauris sapien, cursus in, hendrerit consectetuer, cursus et, magna. Praesent interdum ligula eu enim.'                                                                                                                           , 'sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin vel nisl. Quisque fringilla euismod enim.');
INSERT INTO offtheshelf.faq(question, answer) VALUES ('ut, pharetra sed, hendrerit a, arcu. Sed et libero. Proin mi. Aliquam gravida mauris ut mi. Duis risus odio, auctor vitae, aliquet nec, imperdiet nec, leo. Morbi neque tellus, imperdiet non, vestibulum nec, euismod in, dolor. Fusce feugiat. Lorem ipsum dolor'                     , 'per conubia nostra, per inceptos hymenaeos. Mauris ut quam vel sapien imperdiet ornare.');
INSERT INTO offtheshelf.faq(question, answer) VALUES ('sagittis lobortis mauris. Suspendisse aliquet molestie tellus. Aenean egestas hendrerit neque. In ornare sagittis felis. Donec tempor, est ac mattis semper, dui lectus rutrum urna, nec luctus felis purus ac tellus. Suspendisse'                                                     , 'metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc');
INSERT INTO offtheshelf.faq(question, answer) VALUES ('Aliquam nec enim. Nunc ut erat. Sed nunc est, mollis non, cursus non, egestas a, dui. Cras pellentesque. Sed dictum. Proin'                                                                                                                                                             , 'Fusce mollis. Duis sit amet diam eu dolor egestas rhoncus.');
INSERT INTO offtheshelf.faq(question, answer) VALUES ('non nisi. Aenean eget metus. In nec orci. Donec nibh. Quisque nonummy ipsum non arcu. Vivamus sit amet risus. Donec egestas. Aliquam nec enim. Nunc'                                                                                                                                    , 'tristique pellentesque, tellus sem mollis dui, in sodales elit erat vitae risus. Duis a mi fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus, at fringilla purus mauris a nunc. In at pede. Cras');
INSERT INTO offtheshelf.faq(question, answer) VALUES ('nulla. Integer vulputate, risus a ultricies adipiscing, enim mi tempor lorem, eget mollis lectus pede et risus. Quisque libero lacus, varius et, euismod et, commodo at, libero. Morbi accumsan laoreet ipsum.'                                                                         , 'lorem tristique aliquet. Phasellus fermentum convallis ligula. Donec luctus aliquet odio. Etiam ligula tortor, dictum eu, placerat eget, venenatis a, magna. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam laoreet, libero et tristique pellentesque, tellus sem mollis dui, in sodales elit erat vitae risus. Duis a');

/*Admins*/
/*(id_admin, admin_name, email, admin_password)*/
/*10*/
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (1 , 'Stuart Maxwell'    , 'stuartmaxwell7851@icloud.com'    , 'JtV8zo5B8JN');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (2 , 'Addison Chambers'  , 'addisonchambers2592@outlook.com' , 'WxY6xi4I0MY');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (3 , 'Iona Fletcher'     , 'ionafletcher@hotmai.com'         , 'JcI5tp4H7JO');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (4 , 'Madeline Tate'     , 'madelinetate@yahoo.com'          , 'XdC9ew2N8PN');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (5 , 'Oleg Hensley'      , 'oleghensley5863@outlook.net'     , 'QmI1jj5Y4HI');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (6 , 'Janna Roberts'     , 'jannaroberts6170@icloud.org'     , 'MdH6gw8J1CS');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (7 , 'Rhona Perez'       , 'rhonaperez3509@icloud.com'       , 'AwT6nm6I4UF');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (8 , 'Berk Buchanan'     , 'berkbuchanan2943@icloud.org'     , 'VjN1fv4Z2WV');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (9 , 'Dara Burks'        , 'daraburks@icloud.net'            , 'MeQ3yq3D7TG');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (10, 'Trevor Malone'     , 'trevormalone5887@hotmai.org'     , 'FhC6jd3X1VV');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (11, 'Kaye Weeks'        , 'kayeweeks550@google.com'         , 'SjK6ya7D6TA');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (12, 'Herman Dorsey'     , 'hermandorsey9307@yahoo.com'      , 'TrI1lf7L7XT');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (13, 'Kimberly Maldonado', 'kimberlymaldonado6857@google.org', 'DpR4tn7T8IQ');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (14, 'Jana Roach'        , 'janaroach2537@icloud.org'        , 'BwS5ge3T6GH');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (15, 'Travis Parker'     , 'travisparker6806@google.net'     , 'FuW8sj5F6FD');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (16, 'Alfreda Mcmahon'   , 'alfredamcmahon6324@outlook.net'  , 'EiN3jx4O6FN');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (17, 'Candace Williams'  , 'candacewilliams7395@outlook.org' , 'BxF9sa9Q0CV');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (18, 'Alisa Donaldson'   , 'alisadonaldson6175@yahoo.org'    , 'CiP2mi6T4CI');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (19, 'Tad Fitzpatrick'   , 'tadfitzpatrick3428@yahoo.org'    , 'HrE6co7D8XH');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (20, 'Beverly Parks'     , 'beverlyparks@yahoo.org'          , 'JeY7jo1O9LF');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (21, 'Andrew Alexander'  , 'andrewalexander@google.net'      , 'UnX2eb0O1GK');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (22, 'Brenden Alford'    , 'brendenalford@yahoo.org'         , 'PiU5jk0J3NS');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (23, 'Otto Burton'       , 'ottoburton1363@icloud.org'       , 'HjL3ol1D6AK');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (24, 'Tatyana Briggs'    , 'tatyanabriggs5373@yahoo.com'     , 'HqW8fh2S8BA');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (25, 'Yetta Calderon'    , 'yettacalderon@google.com'        , 'UhV7pk7O7PJ');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (26, 'Hilda Schneider'   , 'hildaschneider2062@outlook.com'  , 'HlF1oy2F1FW');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (27, 'Hilel Kane'        , 'hilelkane3691@google.org'        , 'JlO6mt3Q8LT');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (28, 'Samson Preston'    , 'samsonpreston8171@icloud.net'    , 'RoX6em0S4BJ');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (29, 'Jasper Mayer'      , 'jaspermayer@icloud.org'          , 'CmV7kl5D7VW');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (30, 'Vielka Norman'     , 'vielkanorman8246@icloud.net'     , 'PyC4kf7F8YW');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (31, 'Christine Gray'    , 'christinegray@google.org'        , 'HwO5md4J7DL');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (32, 'Elmo Barton'       , 'elmobarton5734@outlook.net'      , 'OlX3fd1T4QE');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (33, 'Sasha Crosby'      , 'sashacrosby1184@outlook.com'     , 'GnG5mw3T4YU');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (34, 'Anthony Drake'     , 'anthonydrake4095@google.com'     , 'WpV5kv9Q4YX');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (35, 'Isadora Guerra'    , 'isadoraguerra@hotmai.org'        , 'InU9vr8N4IO');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (36, 'Kylynn Sweet'      , 'kylynnsweet@yahoo.net'           , 'MxW3fr9O1TE');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (37, 'Madonna Vang'      , 'madonnavang@google.net'          , 'HkI3ca6B0BH');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (38, 'Shannon Mills'     , 'shannonmills308@hotmai.net'      , 'IdL1jg1M8UX');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (39, 'Elliott Doyle'     , 'elliottdoyle@outlook.com'        , 'OjU9ev2S4SH');
INSERT INTO offtheshelf.admins(id_admin, admin_name, email, admin_password) VALUES (40, 'Juliet Montgomery' , 'julietmontgomery@outlook.org'    , 'KqS3vl2S3EQ');

/*Publisher*/
/*(id_publisher, publisher_name)*/
/*20*/
INSERT INTO offtheshelf.publisher(id_publisher, publisher_name) VALUES (1 , 'quam');
INSERT INTO offtheshelf.publisher(id_publisher, publisher_name) VALUES (2 , 'Nam tempor');
INSERT INTO offtheshelf.publisher(id_publisher, publisher_name) VALUES (3 , 'congue');
INSERT INTO offtheshelf.publisher(id_publisher, publisher_name) VALUES (4 , 'sit amet');
INSERT INTO offtheshelf.publisher(id_publisher, publisher_name) VALUES (5 , 'Ut');
INSERT INTO offtheshelf.publisher(id_publisher, publisher_name) VALUES (6 , 'nisl. Maecenas');
INSERT INTO offtheshelf.publisher(id_publisher, publisher_name) VALUES (7 , 'Quisque ornare');
INSERT INTO offtheshelf.publisher(id_publisher, publisher_name) VALUES (8 , 'ipsum porta');
INSERT INTO offtheshelf.publisher(id_publisher, publisher_name) VALUES (9 , 'erat');
INSERT INTO offtheshelf.publisher(id_publisher, publisher_name) VALUES (10, 'commodo at,');
INSERT INTO offtheshelf.publisher(id_publisher, publisher_name) VALUES (11, 'dignissim.');
INSERT INTO offtheshelf.publisher(id_publisher, publisher_name) VALUES (12, 'sed dui.');
INSERT INTO offtheshelf.publisher(id_publisher, publisher_name) VALUES (13, 'dictum magna.');
INSERT INTO offtheshelf.publisher(id_publisher, publisher_name) VALUES (14, 'eros turpis');
INSERT INTO offtheshelf.publisher(id_publisher, publisher_name) VALUES (15, 'felis.');
INSERT INTO offtheshelf.publisher(id_publisher, publisher_name) VALUES (16, 'nibh. Quisque');
INSERT INTO offtheshelf.publisher(id_publisher, publisher_name) VALUES (17, 'diam');
INSERT INTO offtheshelf.publisher(id_publisher, publisher_name) VALUES (18, 'Morbi metus.');
INSERT INTO offtheshelf.publisher(id_publisher, publisher_name) VALUES (19, 'cursus. Nunc');
INSERT INTO offtheshelf.publisher(id_publisher, publisher_name) VALUES (20, 'ultricies ornare,');

/*Author*/
/*(id_author, author_name)*/
/*20*/
INSERT INTO offtheshelf.author(id_author, author_name) VALUES (1 , 'quis');
INSERT INTO offtheshelf.author(id_author, author_name) VALUES (2 , 'ipsum');
INSERT INTO offtheshelf.author(id_author, author_name) VALUES (3 , 'commodo ipsum.');
INSERT INTO offtheshelf.author(id_author, author_name) VALUES (4 , 'nisl. Quisque');
INSERT INTO offtheshelf.author(id_author, author_name) VALUES (5 , 'urna suscipit');
INSERT INTO offtheshelf.author(id_author, author_name) VALUES (6 , 'Nullam');
INSERT INTO offtheshelf.author(id_author, author_name) VALUES (7 , 'ut,');
INSERT INTO offtheshelf.author(id_author, author_name) VALUES (8 , 'a,');
INSERT INTO offtheshelf.author(id_author, author_name) VALUES (9 , 'Ut');
INSERT INTO offtheshelf.author(id_author, author_name) VALUES (10, 'porttitor eros');
INSERT INTO offtheshelf.author(id_author, author_name) VALUES (11, 'nibh.');
INSERT INTO offtheshelf.author(id_author, author_name) VALUES (12, 'est mauris,');
INSERT INTO offtheshelf.author(id_author, author_name) VALUES (13, 'orci.');
INSERT INTO offtheshelf.author(id_author, author_name) VALUES (14, 'nonummy. Fusce');
INSERT INTO offtheshelf.author(id_author, author_name) VALUES (15, 'congue turpis.');
INSERT INTO offtheshelf.author(id_author, author_name) VALUES (16, 'tincidunt. Donec');
INSERT INTO offtheshelf.author(id_author, author_name) VALUES (17, 'fringilla mi');
INSERT INTO offtheshelf.author(id_author, author_name) VALUES (18, 'gravida.');
INSERT INTO offtheshelf.author(id_author, author_name) VALUES (19, 'dolor, tempus');
INSERT INTO offtheshelf.author(id_author, author_name) VALUES (20, 'Aenean eget');

/*Collections*/
/*(id_collection, collection_name)*/
/*20*/
INSERT INTO offtheshelf.collections(id_collection, collection_name) VALUES (1 ,'mollis.');
INSERT INTO offtheshelf.collections(id_collection, collection_name) VALUES (2 ,'velit');
INSERT INTO offtheshelf.collections(id_collection, collection_name) VALUES (3 ,'malesuada id,');
INSERT INTO offtheshelf.collections(id_collection, collection_name) VALUES (4 ,'orci,');
INSERT INTO offtheshelf.collections(id_collection, collection_name) VALUES (5 ,'nisl sem,');
INSERT INTO offtheshelf.collections(id_collection, collection_name) VALUES (6 ,'lorem,');
INSERT INTO offtheshelf.collections(id_collection, collection_name) VALUES (7 ,'Morbi');
INSERT INTO offtheshelf.collections(id_collection, collection_name) VALUES (8 ,'neque.');
INSERT INTO offtheshelf.collections(id_collection, collection_name) VALUES (9 ,'senectus et');
INSERT INTO offtheshelf.collections(id_collection, collection_name) VALUES (10,'dis parturient');
INSERT INTO offtheshelf.collections(id_collection, collection_name) VALUES (11,'elit.');
INSERT INTO offtheshelf.collections(id_collection, collection_name) VALUES (12,'Cum');
INSERT INTO offtheshelf.collections(id_collection, collection_name) VALUES (13,'Duis');
INSERT INTO offtheshelf.collections(id_collection, collection_name) VALUES (14,'nunc. In');
INSERT INTO offtheshelf.collections(id_collection, collection_name) VALUES (15,'natoque');
INSERT INTO offtheshelf.collections(id_collection, collection_name) VALUES (16,'bibendum');
INSERT INTO offtheshelf.collections(id_collection, collection_name) VALUES (17,'sit amet');
INSERT INTO offtheshelf.collections(id_collection, collection_name) VALUES (18,'ipsum ac');
INSERT INTO offtheshelf.collections(id_collection, collection_name) VALUES (19,'mauris ut');
INSERT INTO offtheshelf.collections(id_collection, collection_name) VALUES (20,'rhoncus. Donec');

/*Category*/
/*(id_category, category_name)*/
/*20*/
INSERT INTO offtheshelf.category(id_category, category_name) VALUES (1 ,'cursus et,');
INSERT INTO offtheshelf.category(id_category, category_name) VALUES (2 ,'dui');
INSERT INTO offtheshelf.category(id_category, category_name) VALUES (3 ,'libero et');
INSERT INTO offtheshelf.category(id_category, category_name) VALUES (4 ,'gravida');
INSERT INTO offtheshelf.category(id_category, category_name) VALUES (5 ,'dictum');
INSERT INTO offtheshelf.category(id_category, category_name) VALUES (6 ,'erat');
INSERT INTO offtheshelf.category(id_category, category_name) VALUES (7 ,'tellus');
INSERT INTO offtheshelf.category(id_category, category_name) VALUES (8 ,'sit');
INSERT INTO offtheshelf.category(id_category, category_name) VALUES (9 ,'cursus');
INSERT INTO offtheshelf.category(id_category, category_name) VALUES (10,'ultricies');
INSERT INTO offtheshelf.category(id_category, category_name) VALUES (11,'morbi');
INSERT INTO offtheshelf.category(id_category, category_name) VALUES (12,'sociis natoque');
INSERT INTO offtheshelf.category(id_category, category_name) VALUES (13,'sagittis felis.');
INSERT INTO offtheshelf.category(id_category, category_name) VALUES (14,'amet massa.');
INSERT INTO offtheshelf.category(id_category, category_name) VALUES (15,'dolor.');
INSERT INTO offtheshelf.category(id_category, category_name) VALUES (16,'vel');
INSERT INTO offtheshelf.category(id_category, category_name) VALUES (17,'Sed diam');
INSERT INTO offtheshelf.category(id_category, category_name) VALUES (18,'lectus convallis');
INSERT INTO offtheshelf.category(id_category, category_name) VALUES (19,'eu,');
INSERT INTO offtheshelf.category(id_category, category_name) VALUES (20,'rhoncus. Proin');

/*Users*/
/*(id_user, username, email, user_password, user_address, phone, blocked)*/
/*20*/
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (1 , 'Amaya Martinez'   , 'amayamartinez@hotmail.org'    , 'Yi5j66VlF4DJ', '696 Magna. Street'                  , '935235731', 'No');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (2 , 'Josephine Morales', 'josephinemorales@yahoo.org'   , 'Pw2y92MsY9NU', 'Ap #600-1576 In St.'                , '935235732', 'No');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (3 , 'Sonya Kent'       , 'sonyakent@yahoo.org'          , 'Uh3p40MpI3ZY', '384-8823 A St.'                     , '935235733', 'No');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (4 , 'Kadeem Cooley'    , 'kadeemcooley8001@icloud.edu'  , 'Hn5f12WzL2LV', 'P.O. Box 630, 1505 Est Street'      , '935235734', 'Yes');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (5 , 'Richard Duke'     , 'richardduke8656@hotmail.edu'  , 'Qr5i67XkI3II', 'Ap #706-5476 Laoreet Ave'           , '935235735', 'No');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (6 , 'Ina Blanchard'    , 'inablanchard@outlook.org'     , 'Vd1s68SyH7SY', '578-9276 Ut Road'                   , '935235736', 'No');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (7 , 'Castor Craig'     , 'castorcraig@outlook.edu'      , 'Se1p60RhV8NC', 'Ap #985-2331 Auctor Av.'            , '935235737', 'No');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (8 , 'Haley Barker'     , 'haleybarker@yahoo.org'        , 'Lj9w14OqT6GL', 'P.O. Box 472, 9907 Urna Rd.'        , '935235738', 'Yes');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (9 , 'Alden Hale'       , 'aldenhale@icloud.net'         , 'Gl2j03OzT4LQ', '896-8186 Cras Road'                 , '935235739', 'No');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (10, 'Randall Bass'     , 'randallbass@hotmail.org'      , 'Ns1j33XsR6LY', 'P.O. Box 498, 7984 Risus. Rd.'      , '935235711', 'No');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (11, 'Olivia Diaz'      , 'oliviadiaz8518@icloud.edu'    , 'Lm6r01GaB1WH', '150-8182 Eu Street'                 , '935235721', 'No');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (12, 'Noelle Ramos'     , 'noelleramos@outlook.org'      , 'Qo6o02IeL7PK', '160-3034 Ipsum. Av.'                , '935235731', 'No');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (13, 'Lacy Rosa'        , 'lacyrosa@google.org'          , 'Ub8k23TkE4FW', '5418 Lorem Av.'                     , '935235741', 'Yes');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (14, 'Zephr Mcknight'   , 'zephrmcknight1657@hotmail.org', 'Ql5w29UlG4PW', 'Ap #446-1037 Mauris Rd.'            , '935235751', 'Yes');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (15, 'Brooke Winters'   , 'brookewinters@outlook.net'    , 'Hj2h09JjZ4OF', '975 Semper St.'                     , '935235761', 'No');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (16, 'Dorian Craig'     , 'doriancraig@yahoo.edu'        , 'Ds3c51WlF0RB', '698-3560 Nulla Street'              , '935235771', 'No');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (17, 'Zelda Pugh'       , 'zeldapugh@outlook.org'        , 'Mq3s43NiE8FV', 'P.O. Box 373, 6965 Tincidunt Avenue', '935235781', 'No');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (18, 'Harriet Tyler'    , 'harriettyler@icloud.com'      , 'Hl1c27YhX7DK', 'Ap #530-451 Nulla. St.'             , '935235791', 'Yes');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (19, 'John Bean'        , 'johnbean@outlook.com'         , 'Ku6x81PsO5VO', 'Ap #391-2361 Enim Rd.'              , '935235131', 'No');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (20, 'Colt Mcgee'       , 'coltmcgee@hotmail.edu'        , 'Ul4v13PaU7ME', '8470 Sem Av.'                       , '935235231', 'No');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (21, 'Caryn Savage'     , 'carynsavage5347@yahoo.com'    , 'Lh5b53RrF2NF', '427-6336 Erat. St.'                 , '935235331', 'No');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (22, 'Emerald Simpson'  , 'emeraldsimpson@yahoo.edu'     , 'Nj1j14RyC3QM', '522-8972 Nam Road'                  , '935235431', 'Yes');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (23, 'Samantha Robinson', 'samantharobinson@google.net'  , 'Kj6g76RkD3NJ', '437-691 Id, Street'                 , '935235531', 'Yes');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (24, 'Britanney Boyer'  , 'britanneyboyer@hotmail.edu'   , 'Th1p81YwJ9ST', '287-4462 Erat Street'               , '935235631', 'No');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (25, 'Baker Herring'    , 'bakerherring398@outlook.net'  , 'Ug6k66VoS6HO', 'P.O. Box 405, 3346 Diam Street'     , '935235731', 'Yes');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (26, 'Malachi Wagner'   , 'malachiwagner2630@yahoo.org'  , 'Bo2c98ImG4JM', '458-5762 Eu, Av.'                   , '935235831', 'No');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (27, 'Jordan Burnett'   , 'jordanburnett6347@icloud.org' , 'Zf3s86TyU3TL', '3977 Eu Road'                       , '935235931', 'Yes');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (28, 'Maite Todd'       , 'maitetodd@yahoo.edu'          , 'Ll8j83PyV9UA', 'Ap #390-7619 Suspendisse Rd.'       , '935231731', 'Yes');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (29, 'Rhonda Norton'    , 'rhondanorton@hotmail.com'     , 'Ih1c26UkP4YK', 'P.O. Box 853, 4472 Massa. Av.'      , '935232731', 'No');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (30, 'Emery Sellers'    , 'emerysellers5460@outlook.org' , 'Up1b27LcA5ZU', 'Ap #173-8311 Viverra. Rd.'          , '935233731', 'Yes');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (31, 'Giselle Marshall' , 'gisellemarshall@outlook.net'  , 'Yf4r13VvV7OT', '929-294 Luctus Road'                , '935234731', 'No');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (32, 'Anika Dunn'       , 'anikadunn@google.com'         , 'Xc5l22HhX5RX', 'Ap #483-1333 Integer Rd.'           , '935235731', 'No');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (33, 'Dai Macias'       , 'daimacias3314@icloud.net'     , 'Gd6n50OoJ8NL', '306-8798 Rutrum. Av.'               , '935236731', 'Yes');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (34, 'Jessica Garrett'  , 'jessicagarrett9683@icloud.edu', 'Yw3j31HxD5PA', 'Ap #104-3266 Lacinia Avenue'        , '935237731', 'Yes');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (35, 'Audra Lowery'     , 'audralowery5397@icloud.edu'   , 'Wy2j56KwO6HP', '550-6475 Aliquam Road'              , '935238731', 'Yes');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (36, 'Melanie Riggs'    , 'melanieriggs3829@outlook.net' , 'Fp2f31OiI5QX', '729-9959 Lorem Rd.'                 , '935239731', 'No');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (37, 'Kirk Delaney'     , 'kirkdelaney7896@icloud.com'   , 'Ux4o26GuV6QL', 'Ap #894-3832 Feugiat Rd.'           , '935215731', 'No');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (38, 'Noble Herring'    , 'nobleherring@icloud.com'      , 'Gb2s65QgX6XA', 'Ap #460-2401 Donec Av.'             , '935225731', 'Yes');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (39, 'Caesar Osborne'   , 'caesarosborne8677@icloud.net' , 'Wl3o65RiS1KW', '754-2268 Duis St.'                  , '935235731', 'Yes');
INSERT INTO offtheshelf.users(id_user, username, email, user_password, user_address, phone, blocked) VALUES (40, 'Barrett Bell'     , 'barrettbell3569@google.net'   , 'Xj5p44TsE4AR', 'P.O. Box 244, 8737 Erat, St.'       , '935245731', 'Yes');

/*Book*/
/*(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher)*/
/*40*/
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (1 , 'aliquam arcu. Aliquam ultrices iaculis odio.'     , 5351034105, 1918, '112.90', 5 , 5, 'est, congue a, aliquet vel, vulputate eu, odio. Phasellus at augue id ante dictum cursus. Nunc mauris elit, dictum eu, eleifend nec, malesuada ut, sem. Nulla interdum. Curabitur dictum. Phasellus in felis. Nulla tempor augue ac ipsum. Phasellus vitae mauris sit amet lorem semper auctor.'                                                                                                                                                                                                                                                                                , 1 , 1 );
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (2 , 'dolor. Donec fringilla. Donec feugiat metus'      , 4733319526, 1970, '162.18', 29, 6, 'commodo auctor velit. Aliquam nisl. Nulla eu neque pellentesque massa lobortis ultrices. Vivamus rhoncus. Donec est. Nunc ullamcorper, velit in aliquet lobortis, nisi nibh lacinia orci, consectetuer euismod est arcu ac orci. Ut semper pretium neque. Morbi quis urna. Nunc quis arcu vel quam dignissim pharetra. Nam ac nulla. In tincidunt congue turpis. In condimentum. Donec at'                                                                                                                                                                                      , 2 , 2 );
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (3 , 'ornare, elit elit fermentum risus, at'            , 3638368148, 2022, '7.07'  , 4 , 0, 'nulla. In tincidunt congue turpis. In condimentum. Donec at arcu. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae Donec tincidunt. Donec vitae erat vel pede blandit congue. In scelerisque scelerisque dui. Suspendisse ac metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc nulla vulputate dui, nec tempus mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae diam. Proin dolor. Nulla semper tellus id nunc interdum feugiat.'                                                                  , 3 , 3 );
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (4 , 'egestas a, dui. Cras pellentesque. Sed'           , 1559765489, 1962, '111.84', 30, 4, 'eros turpis non enim. Mauris quis turpis vitae purus gravida sagittis. Duis gravida. Praesent eu nulla at sem molestie sodales. Mauris blandit enim consequat purus. Maecenas libero est, congue a, aliquet vel, vulputate eu, odio. Phasellus at augue id ante dictum cursus. Nunc mauris elit, dictum eu, eleifend nec, malesuada ut, sem. Nulla interdum. Curabitur dictum.'                                                                                                                                                                                                 , 4 , 4 );
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (5 , 'Quisque tincidunt pede ac urna. Ut'               , 7100265623, 2022, '55.89' , 18, 3, 'sit amet ornare lectus justo eu arcu. Morbi sit amet massa. Quisque porttitor eros nec tellus. Nunc lectus pede, ultrices a, auctor non, feugiat nec, diam. Duis mi enim, condimentum eget, volutpat ornare, facilisis eget, ipsum. Donec sollicitudin adipiscing ligula. Aenean gravida nunc sed pede. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin vel arcu eu odio tristique pharetra. Quisque'                                                                                                                               , 5 , 5 );
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (6 , 'libero. Proin mi. Aliquam gravida mauris'         , 3985700232, 2007, '177.01', 2 , 7, 'tempor lorem, eget mollis lectus pede et risus. Quisque libero lacus, varius et, euismod et, commodo at, libero. Morbi accumsan laoreet ipsum. Curabitur consequat, lectus sit amet luctus vulputate, nisi sem semper erat, in consectetuer ipsum nunc id enim. Curabitur massa. Vestibulum accumsan neque et nunc. Quisque ornare tortor at risus. Nunc ac sem ut dolor dapibus gravida.'                                                                                                                                                                                      , 6 , 6 );
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (7 , 'orci lacus vestibulum lorem, sit amet'            , 7807449319, 1948, '179.27', 1 , 2, 'ut, nulla. Cras eu tellus eu augue porttitor interdum. Sed auctor odio a purus. Duis elementum, dui quis accumsan convallis, ante lectus convallis est, vitae sodales nisi magna sed dui. Fusce aliquam, enim nec tempus scelerisque, lorem ipsum sodales purus, in molestie tortor nibh sit amet orci. Ut sagittis lobortis mauris. Suspendisse aliquet molestie tellus. Aenean egestas hendrerit neque. In ornare sagittis felis. Donec tempor, est'                                                                                                                          , 7 , 7 );
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (8 , 'vel est tempor bibendum. Donec felis'             , 7155626270, 1904, '39.49' , 37, 7, 'bibendum. Donec felis orci, adipiscing non, luctus sit amet, faucibus ut, nulla. Cras eu tellus eu augue porttitor interdum. Sed auctor odio a purus. Duis elementum, dui quis accumsan convallis, ante lectus convallis est, vitae sodales nisi magna sed dui. Fusce aliquam, enim nec tempus scelerisque, lorem ipsum sodales purus, in molestie tortor nibh sit amet orci. Ut sagittis lobortis mauris. Suspendisse aliquet molestie tellus. Aenean egestas hendrerit neque. In ornare sagittis felis. Donec tempor, est ac mattis semper, dui'                              , 8 , 8 );
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (9 , 'ultricies sem magna nec quam. Curabitur'          , 6001574761, 1925, '152.70', 23, 4, 'Duis dignissim tempor arcu. Vestibulum ut eros non enim commodo hendrerit. Donec porttitor tellus non magna. Nam ligula elit, pretium et, rutrum non, hendrerit id, ante. Nunc mauris sapien, cursus in, hendrerit consectetuer, cursus et, magna. Praesent interdum ligula eu enim. Etiam imperdiet dictum magna. Ut tincidunt orci quis lectus. Nullam suscipit, est ac facilisis facilisis, magna tellus faucibus leo, in lobortis'                                                                                                                                          , 9 , 9 );
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (10, 'ornare, lectus ante dictum mi, ac'                , 1009054957, 2017, '92.34' , 23, 7, 'ut, sem. Nulla interdum. Curabitur dictum. Phasellus in felis. Nulla tempor augue ac ipsum. Phasellus vitae mauris sit amet lorem semper auctor. Mauris vel turpis. Aliquam adipiscing lobortis risus. In mi pede, nonummy ut, molestie in, tempus eu, ligula. Aenean euismod mauris eu elit. Nulla facilisi. Sed neque. Sed eget lacus. Mauris non dui nec urna suscipit'                                                                                                                                                                                                      , 10, 10);
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (11, 'mi lorem, vehicula et, rutrum eu,'                , 4021295362, 1902, '115.63', 10, 7, 'enim, gravida sit amet, dapibus id, blandit at, nisi. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin vel nisl. Quisque fringilla euismod enim. Etiam gravida molestie arcu. Sed eu nibh vulputate mauris sagittis placerat. Cras dictum ultricies ligula. Nullam enim. Sed nulla ante, iaculis nec, eleifend non, dapibus rutrum, justo. Praesent'                                                                                                                                                                                 , 11, 11);
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (12, 'habitant morbi tristique senectus et netus'       , 2296228739, 1955, '87.29' , 36, 2, 'ultrices iaculis odio. Nam interdum enim non nisi. Aenean eget metus. In nec orci. Donec nibh. Quisque nonummy ipsum non arcu. Vivamus sit amet risus. Donec egestas. Aliquam nec enim. Nunc ut erat. Sed nunc est, mollis non, cursus non, egestas a, dui. Cras pellentesque. Sed dictum. Proin eget odio.'                                                                                                                                                                                                                                                                    , 12, 12);
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (13, 'viverra. Donec tempus, lorem fringilla ornare'    , 4165265219, 1963, '190.06', 15, 9, 'eu tempor erat neque non quam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam fringilla cursus purus. Nullam scelerisque neque sed sem egestas blandit. Nam nulla magna, malesuada vel, convallis in, cursus et, eros. Proin ultrices. Duis volutpat'                                                                                                                                                                                                                                                                    , 13, 13);
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (14, 'blandit congue. In scelerisque scelerisque dui.'  , 1387719406, 1953, '118.66', 37, 2, 'accumsan neque et nunc. Quisque ornare tortor at risus. Nunc ac sem ut dolor dapibus gravida. Aliquam tincidunt, nunc ac mattis ornare, lectus ante dictum mi, ac mattis velit justo nec ante. Maecenas mi felis, adipiscing fringilla, porttitor vulputate, posuere vulputate, lacus. Cras interdum. Nunc sollicitudin commodo ipsum. Suspendisse non leo. Vivamus nibh dolor, nonummy ac, feugiat non, lobortis quis, pede. Suspendisse'                                                                                                                                      , 14, 14);
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (15, 'mattis ornare, lectus ante dictum mi,'            , 4626286507, 1910, '189.28', 25, 2, 'a, aliquet vel, vulputate eu, odio. Phasellus at augue id ante dictum cursus. Nunc mauris elit, dictum eu, eleifend nec, malesuada ut, sem. Nulla interdum. Curabitur dictum. Phasellus in felis. Nulla tempor augue ac ipsum. Phasellus vitae mauris sit amet lorem semper auctor. Mauris vel turpis.'                                                                                                                                                                                                                                                                         , 15, 15);
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (16, 'ultricies dignissim lacus. Aliquam rutrum lorem'  , 6780079320, 1926, '104.15', 28, 2, 'In at pede. Cras vulputate velit eu sem. Pellentesque ut ipsum ac mi eleifend egestas. Sed pharetra, felis eget varius ultrices, mauris ipsum porta elit, a feugiat tellus lorem eu metus. In lorem. Donec elementum, lorem ut aliquam iaculis, lacus pede sagittis augue, eu tempor erat'                                                                                                                                                                                                                                                                                      , 16, 16);
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (17, 'urna suscipit nonummy. Fusce fermentum fermentum' , 8775074045, 1910, '6.44'  , 3 , 2, 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean eget magna. Suspendisse tristique neque venenatis lacus. Etiam bibendum fermentum metus. Aenean sed pede nec ante blandit viverra. Donec tempus, lorem fringilla ornare placerat, orci lacus vestibulum lorem, sit amet ultricies sem magna nec quam. Curabitur vel lectus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.'                                                                                                                 , 17, 17);
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (18, 'Duis mi enim, condimentum eget, volutpat'         , 6101435705, 1927, '37.27' , 29, 3, 'sed dolor. Fusce mi lorem, vehicula et, rutrum eu, ultrices sit amet, risus. Donec nibh enim, gravida sit amet, dapibus id, blandit at, nisi. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin vel nisl. Quisque fringilla euismod enim. Etiam gravida molestie arcu. Sed eu nibh vulputate mauris sagittis placerat. Cras dictum ultricies ligula. Nullam'                                                                                                                                                                          , 18, 18);
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (19, 'id, blandit at, nisi. Cum sociis'                 , 3523753213, 1934, '84.92' , 17, 4, 'commodo tincidunt nibh. Phasellus nulla. Integer vulputate, risus a ultricies adipiscing, enim mi tempor lorem, eget mollis lectus pede et risus. Quisque libero lacus, varius et, euismod et, commodo at, libero. Morbi accumsan laoreet ipsum. Curabitur consequat, lectus sit amet luctus vulputate, nisi sem semper erat, in consectetuer ipsum nunc id enim. Curabitur massa. Vestibulum accumsan neque et nunc. Quisque ornare tortor at risus. Nunc ac sem ut dolor dapibus gravida. Aliquam tincidunt,'                                                                 , 19, 19);
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (20, 'iaculis quis, pede. Praesent eu dui.'             , 5100753229, 1964, '171.18', 12, 3, 'Nam ligula elit, pretium et, rutrum non, hendrerit id, ante. Nunc mauris sapien, cursus in, hendrerit consectetuer, cursus et, magna. Praesent interdum ligula eu enim. Etiam imperdiet dictum magna. Ut tincidunt orci quis lectus. Nullam suscipit, est ac facilisis facilisis, magna tellus faucibus leo, in lobortis tellus justo sit amet nulla. Donec non justo.'                                                                                                                                                                                                         , 20, 20);
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (21, 'molestie tellus. Aenean egestas hendrerit neque.' , 6469905866, 1911, '80.20' , 11, 4, 'ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae Donec tincidunt. Donec vitae erat vel pede blandit congue. In scelerisque scelerisque dui. Suspendisse ac metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc nulla vulputate dui, nec tempus mauris erat'                                                                                                                                                                                                                                                               , 1 , 1 );
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (22, 'dictum sapien. Aenean massa. Integer vitae'       , 1779430274, 1972, '31.46' , 29, 4, 'ac facilisis facilisis, magna tellus faucibus leo, in lobortis tellus justo sit amet nulla. Donec non justo. Proin non massa non ante bibendum ullamcorper. Duis cursus, diam at pretium aliquet, metus urna convallis erat, eget tincidunt dui augue eu tellus. Phasellus elit pede, malesuada vel, venenatis vel, faucibus id, libero. Donec consectetuer mauris'                                                                                                                                                                                                             , 2 , 2 );
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (23, 'facilisis vitae, orci. Phasellus dapibus quam'    , 6173307196, 1998, '110.88', 20, 8, 'odio a purus. Duis elementum, dui quis accumsan convallis, ante lectus convallis est, vitae sodales nisi magna sed dui. Fusce aliquam, enim nec tempus scelerisque, lorem ipsum sodales purus, in molestie tortor nibh sit amet orci. Ut sagittis lobortis mauris. Suspendisse aliquet molestie tellus. Aenean egestas hendrerit neque. In ornare sagittis felis.'                                                                                                                                                                                                              , 3 , 3 );
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (24, 'semper erat, in consectetuer ipsum nunc'          , 2833190201, 2013, '198.13', 23, 7, 'Nullam suscipit, est ac facilisis facilisis, magna tellus faucibus leo, in lobortis tellus justo sit amet nulla. Donec non justo. Proin non massa non ante bibendum ullamcorper. Duis cursus, diam at pretium aliquet, metus urna convallis erat, eget tincidunt dui augue eu tellus. Phasellus elit pede, malesuada vel, venenatis vel, faucibus id, libero. Donec consectetuer mauris id sapien. Cras dolor dolor, tempus non, lacinia at, iaculis quis, pede. Praesent'                                                                                                      , 4 , 4 );
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (25, 'vulputate eu, odio. Phasellus at augue'           , 7976254226, 1997, '182.67', 6 , 4, 'sem molestie sodales. Mauris blandit enim consequat purus. Maecenas libero est, congue a, aliquet vel, vulputate eu, odio. Phasellus at augue id ante dictum cursus. Nunc mauris elit, dictum eu, eleifend nec, malesuada ut, sem. Nulla interdum. Curabitur dictum. Phasellus in felis. Nulla tempor augue ac ipsum. Phasellus vitae mauris sit amet lorem semper auctor. Mauris vel turpis. Aliquam adipiscing'                                                                                                                                                               , 5 , 5 );
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (26, 'quam a felis ullamcorper viverra. Maecenas'       , 7159599748, 2015, '184.75', 34, 7, 'justo nec ante. Maecenas mi felis, adipiscing fringilla, porttitor vulputate, posuere vulputate, lacus. Cras interdum. Nunc sollicitudin commodo ipsum. Suspendisse non leo. Vivamus nibh dolor, nonummy ac, feugiat non, lobortis quis, pede. Suspendisse dui. Fusce diam nunc, ullamcorper eu, euismod ac, fermentum vel, mauris. Integer sem elit, pharetra ut, pharetra sed, hendrerit a,'                                                                                                                                                                                  , 6 , 6 );
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (27, 'semper rutrum. Fusce dolor quam, elementum'       , 4874679075, 2004, '133.17', 3 , 1, 'mollis. Phasellus libero mauris, aliquam eu, accumsan sed, facilisis vitae, orci. Phasellus dapibus quam quis diam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Fusce aliquet magna a neque. Nullam ut nisi a odio semper cursus. Integer mollis. Integer tincidunt aliquam arcu. Aliquam ultrices iaculis odio. Nam interdum enim non nisi. Aenean eget metus. In nec orci. Donec nibh. Quisque nonummy ipsum non arcu.'                                                                                                     , 7 , 7 );
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (28, 'Pellentesque habitant morbi tristique senectus et', 4796042846, 1991, '54.77' , 39, 8, 'eget, volutpat ornare, facilisis eget, ipsum. Donec sollicitudin adipiscing ligula. Aenean gravida nunc sed pede. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin vel arcu eu odio tristique pharetra. Quisque ac libero nec ligula consectetuer rhoncus. Nullam velit dui, semper et, lacinia vitae, sodales at, velit. Pellentesque ultricies dignissim lacus. Aliquam rutrum lorem ac risus. Morbi metus. Vivamus euismod urna. Nullam lobortis quam a felis ullamcorper viverra. Maecenas iaculis aliquet diam. Sed diam lorem,', 8 , 8 );
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (29, 'consequat nec, mollis vitae, posuere at,'         , 1156148782, 1986, '86.68' , 23, 9, 'elementum sem, vitae aliquam eros turpis non enim. Mauris quis turpis vitae purus gravida sagittis. Duis gravida. Praesent eu nulla at sem molestie sodales. Mauris blandit enim consequat purus. Maecenas libero est, congue a, aliquet vel, vulputate eu, odio. Phasellus at augue id ante dictum cursus. Nunc mauris elit, dictum eu, eleifend nec, malesuada ut, sem. Nulla interdum. Curabitur dictum. Phasellus in felis.'                                                                                                                                                , 9 , 9 );
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (30, 'magna tellus faucibus leo, in lobortis'           , 1970729728, 1999, '122.58', 15, 2, 'magna, malesuada vel, convallis in, cursus et, eros. Proin ultrices. Duis volutpat nunc sit amet metus. Aliquam erat volutpat. Nulla facilisis. Suspendisse commodo tincidunt nibh. Phasellus nulla. Integer vulputate, risus a ultricies adipiscing, enim mi tempor lorem, eget mollis lectus pede et risus. Quisque libero lacus, varius et, euismod et, commodo at, libero. Morbi accumsan laoreet ipsum. Curabitur consequat,'                                                                                                                                              , 10, 10);
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (31, 'tempus mauris erat eget ipsum. Suspendisse'       , 2896185986, 1943, '50.29' , 4 , 5, 'id risus quis diam luctus lobortis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Mauris ut quam vel sapien imperdiet ornare. In faucibus. Morbi vehicula. Pellentesque tincidunt tempus risus. Donec egestas. Duis ac arcu. Nunc mauris. Morbi non'                                                                                                                                                                                                                                                                              , 11, 11);
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (32, 'amet ultricies sem magna nec quam.'               , 4413762605, 1933, '47.79' , 5 , 0, 'Curae Phasellus ornare. Fusce mollis. Duis sit amet diam eu dolor egestas rhoncus. Proin nisl sem, consequat nec, mollis vitae, posuere at, velit. Cras lorem lorem, luctus ut, pellentesque eget, dictum placerat, augue. Sed molestie. Sed id risus quis diam luctus lobortis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Mauris ut quam vel'                                                                                                                                                                                , 12, 12);
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (33, 'Aenean euismod mauris eu elit. Nulla'             , 1737497363, 1962, '97.13' , 5 , 6, 'tincidunt tempus risus. Donec egestas. Duis ac arcu. Nunc mauris. Morbi non sapien molestie orci tincidunt adipiscing. Mauris molestie pharetra nibh. Aliquam ornare, libero at auctor ullamcorper, nisl arcu iaculis enim, sit amet ornare lectus justo eu arcu. Morbi sit amet massa. Quisque porttitor eros nec tellus.'                                                                                                                                                                                                                                                     , 13, 13);
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (34, 'faucibus leo, in lobortis tellus justo'           , 8236943410, 1902, '37.23' , 23, 7, 'mauris, aliquam eu, accumsan sed, facilisis vitae, orci. Phasellus dapibus quam quis diam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Fusce aliquet magna a neque. Nullam ut nisi a odio semper cursus. Integer mollis. Integer tincidunt aliquam arcu. Aliquam ultrices iaculis odio. Nam interdum enim non nisi. Aenean eget metus. In nec orci. Donec nibh. Quisque nonummy ipsum non arcu. Vivamus sit amet risus. Donec egestas. Aliquam nec enim. Nunc'                                                                , 14, 14);
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (35, 'Curabitur sed tortor. Integer aliquam adipiscing' , 1982054293, 1992, '147.31', 21, 4, 'Nulla interdum. Curabitur dictum. Phasellus in felis. Nulla tempor augue ac ipsum. Phasellus vitae mauris sit amet lorem semper auctor. Mauris vel turpis. Aliquam adipiscing lobortis risus. In mi pede, nonummy ut, molestie in, tempus eu, ligula. Aenean euismod mauris eu elit. Nulla facilisi. Sed neque. Sed eget lacus.'                                                                                                                                                                                                                                                , 15, 15);
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (36, 'ipsum ac mi eleifend egestas. Sed'                , 7976132603, 2014, '90.57' , 2 , 0, 'augue ut lacus. Nulla tincidunt, neque vitae semper egestas, urna justo faucibus lectus, a sollicitudin orci sem eget massa. Suspendisse eleifend. Cras sed leo. Cras vehicula aliquet libero. Integer in magna. Phasellus dolor elit, pellentesque a, facilisis non, bibendum sed, est. Nunc laoreet lectus quis massa. Mauris vestibulum, neque sed dictum eleifend, nunc risus varius orci, in consequat enim diam vel arcu. Curabitur ut odio'                                                                                                                              , 16, 16);
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (37, 'diam lorem, auctor quis, tristique ac,'           , 2883715660, 1993, '31.63' , 25, 7, 'pede ac urna. Ut tincidunt vehicula risus. Nulla eget metus eu erat semper rutrum. Fusce dolor quam, elementum at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et pede. Nunc sed orci lobortis augue scelerisque mollis. Phasellus libero mauris, aliquam eu, accumsan sed, facilisis vitae, orci. Phasellus dapibus quam quis diam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Fusce aliquet magna a neque. Nullam ut nisi a odio'                                                                               , 17, 17);
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (38, 'elit, a feugiat tellus lorem eu'                  , 8641984654, 1974, '148.75', 7 , 7, 'vitae dolor. Donec fringilla. Donec feugiat metus sit amet ante. Vivamus non lorem vitae odio sagittis semper. Nam tempor diam dictum sapien. Aenean massa. Integer vitae nibh. Donec est mauris, rhoncus id, mollis nec, cursus a, enim. Suspendisse aliquet, sem ut cursus luctus, ipsum leo elementum sem, vitae aliquam eros turpis non enim. Mauris quis turpis vitae purus gravida sagittis. Duis gravida. Praesent eu nulla at sem molestie'                                                                                                                             , 18, 18);
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (39, 'ultrices iaculis odio. Nam interdum enim'         , 6393537848, 2014, '111.38', 35, 3, 'vitae risus. Duis a mi fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus, at fringilla purus mauris a nunc. In at pede. Cras vulputate velit eu sem. Pellentesque ut ipsum ac mi eleifend egestas. Sed pharetra, felis eget varius ultrices, mauris ipsum porta elit, a feugiat'                                                                                                                                                                                                                       , 19, 19);
INSERT INTO offtheshelf.book(id_book, title, isbn, year, prive, stock, book_edition, book_description, id_category, id_publisher) VALUES (40, 'aliquet libero. Integer in magna. Phasellus'      , 7965245093, 2016, '2.20'  , 12, 0, 'erat nonummy ultricies ornare, elit elit fermentum risus, at fringilla purus mauris a nunc. In at pede. Cras vulputate velit eu sem. Pellentesque ut ipsum ac mi eleifend egestas. Sed pharetra, felis eget varius ultrices, mauris ipsum porta elit, a feugiat tellus lorem eu metus. In lorem. Donec elementum, lorem ut aliquam iaculis, lacus pede sagittis augue, eu tempor'                                                                                                                                                                                               , 20, 20);

/*Wishlist*/
/*(id_user, id_book)*/
/*20*/
INSERT INTO offtheshelf.wishlist(id_user, id_book) VALUES (1 ,1 );
INSERT INTO offtheshelf.wishlist(id_user, id_book) VALUES (2 ,2 );
INSERT INTO offtheshelf.wishlist(id_user, id_book) VALUES (3 ,3 );
INSERT INTO offtheshelf.wishlist(id_user, id_book) VALUES (4 ,4 );
INSERT INTO offtheshelf.wishlist(id_user, id_book) VALUES (5 ,5 );
INSERT INTO offtheshelf.wishlist(id_user, id_book) VALUES (6 ,6 );
INSERT INTO offtheshelf.wishlist(id_user, id_book) VALUES (7 ,7 );
INSERT INTO offtheshelf.wishlist(id_user, id_book) VALUES (8 ,8 );
INSERT INTO offtheshelf.wishlist(id_user, id_book) VALUES (9 ,9 );
INSERT INTO offtheshelf.wishlist(id_user, id_book) VALUES (10,10);
INSERT INTO offtheshelf.wishlist(id_user, id_book) VALUES (11,11);
INSERT INTO offtheshelf.wishlist(id_user, id_book) VALUES (12,12);
INSERT INTO offtheshelf.wishlist(id_user, id_book) VALUES (13,13);
INSERT INTO offtheshelf.wishlist(id_user, id_book) VALUES (14,14);
INSERT INTO offtheshelf.wishlist(id_user, id_book) VALUES (15,15);
INSERT INTO offtheshelf.wishlist(id_user, id_book) VALUES (16,16);
INSERT INTO offtheshelf.wishlist(id_user, id_book) VALUES (17,17);
INSERT INTO offtheshelf.wishlist(id_user, id_book) VALUES (18,18);
INSERT INTO offtheshelf.wishlist(id_user, id_book) VALUES (19,19);
INSERT INTO offtheshelf.wishlist(id_user, id_book) VALUES (20,20);

/*Cart*/
/*(id_user, id_book)*/
/*20*/
INSERT INTO offtheshelf.cart(id_user, id_book) VALUES (1 ,1 );
INSERT INTO offtheshelf.cart(id_user, id_book) VALUES (2 ,2 );
INSERT INTO offtheshelf.cart(id_user, id_book) VALUES (3 ,3 );
INSERT INTO offtheshelf.cart(id_user, id_book) VALUES (4 ,4 );
INSERT INTO offtheshelf.cart(id_user, id_book) VALUES (5 ,5 );
INSERT INTO offtheshelf.cart(id_user, id_book) VALUES (6 ,6 );
INSERT INTO offtheshelf.cart(id_user, id_book) VALUES (7 ,7 );
INSERT INTO offtheshelf.cart(id_user, id_book) VALUES (8 ,8 );
INSERT INTO offtheshelf.cart(id_user, id_book) VALUES (9 ,9 );
INSERT INTO offtheshelf.cart(id_user, id_book) VALUES (10,10);
INSERT INTO offtheshelf.cart(id_user, id_book) VALUES (11,11);
INSERT INTO offtheshelf.cart(id_user, id_book) VALUES (12,12);
INSERT INTO offtheshelf.cart(id_user, id_book) VALUES (13,13);
INSERT INTO offtheshelf.cart(id_user, id_book) VALUES (14,14);
INSERT INTO offtheshelf.cart(id_user, id_book) VALUES (15,15);
INSERT INTO offtheshelf.cart(id_user, id_book) VALUES (16,16);
INSERT INTO offtheshelf.cart(id_user, id_book) VALUES (17,17);
INSERT INTO offtheshelf.cart(id_user, id_book) VALUES (18,18);
INSERT INTO offtheshelf.cart(id_user, id_book) VALUES (19,19);
INSERT INTO offtheshelf.cart(id_user, id_book) VALUES (20,20);

/*Purchase*/
/*(id_purchase, purchase_date, id_user, state_purchase)*/
/*10*/
INSERT INTO offtheshelf.purchase(id_purchase, purchase_date, id_user, state_purchase) VALUES (1 ,'2022-07-13 14:03:42 +9:00',1 , 'Received');
INSERT INTO offtheshelf.purchase(id_purchase, purchase_date, id_user, state_purchase) VALUES (2 ,'2022-01-30 09:05:56 +8:00',2 , 'Received');
INSERT INTO offtheshelf.purchase(id_purchase, purchase_date, id_user, state_purchase) VALUES (3 ,'2021-12-22 22:21:03 -4:00',3 , 'Received');
INSERT INTO offtheshelf.purchase(id_purchase, purchase_date, id_user, state_purchase) VALUES (4 ,'2021-04-04 12:17:47 -4:00',4 , 'Received');
INSERT INTO offtheshelf.purchase(id_purchase, purchase_date, id_user, state_purchase) VALUES (5 ,'2021-07-04 01:43:53 -8:00',5 , 'Dispatched');
INSERT INTO offtheshelf.purchase(id_purchase, purchase_date, id_user, state_purchase) VALUES (6 ,'2022-03-22 16:50:18 +2:00',6 , 'Dispatched');
INSERT INTO offtheshelf.purchase(id_purchase, purchase_date, id_user, state_purchase) VALUES (7 ,'2021-10-18 22:29:36 +7:00',7 , 'Dispatched');
INSERT INTO offtheshelf.purchase(id_purchase, purchase_date, id_user, state_purchase) VALUES (8 ,'2021-07-17 17:33:03 -0:00',8 , 'Dispatched');
INSERT INTO offtheshelf.purchase(id_purchase, purchase_date, id_user, state_purchase) VALUES (9 ,'2021-11-13 13:42:04 +9:00',9 , 'Delivered');
INSERT INTO offtheshelf.purchase(id_purchase, purchase_date, id_user, state_purchase) VALUES (10,'2022-04-05 05:17:14 +4:00',10, 'Delivered');

/*Photo*/
/*(id_photo, photo_image, id_book, id_user, id_admin)*/
/*40*/
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (1 , 'https://', 1 , 1 , 1 );
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (2 , 'https://', 2 , 2 , 2 );
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (3 , 'https://', 3 , 3 , 3 );
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (4 , 'https://', 4 , 4 , 4 );
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (5 , 'http://' , 5 , 5 , 5 );
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (6 , 'https://', 6 , 6 , 6 );
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (7 , 'https://', 7 , 7 , 7 );
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (8 , 'http://' , 8 , 8 , 8 );
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (9 , 'https://', 9 , 9 , 9 );
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (10, 'http://' , 10, 10, 10);
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (11, 'http://' , 11, 11, 11);
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (12, 'http://' , 12, 12, 12);
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (13, 'http://' , 13, 13, 13);
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (14, 'http://' , 14, 14, 14);
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (15, 'http://' , 15, 15, 15);
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (16, 'https://', 16, 16, 16);
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (17, 'http://' , 17, 17, 17);
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (18, 'http://' , 18, 18, 18);
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (19, 'http://' , 19, 19, 19);
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (20, 'https://', 20, 20, 20);
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (21, 'https://', 21, 21, 21);
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (22, 'http://' , 22, 22, 22);
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (23, 'http://' , 23, 23, 23);
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (24, 'https://', 24, 24, 24);
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (25, 'https://', 25, 25, 25);
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (26, 'http://' , 26, 26, 26);
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (27, 'https://', 27, 27, 27);
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (28, 'https://', 28, 28, 28);
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (29, 'https://', 29, 29, 29);
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (30, 'http://' , 30, 30, 30);
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (31, 'https://', 31, 31, 31);
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (32, 'http://' , 32, 32, 32);
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (33, 'https://', 33, 33, 33);
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (34, 'https://', 34, 34, 34);
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (35, 'http://' , 35, 35, 35);
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (36, 'https://', 36, 36, 36);
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (37, 'http://' , 37, 37, 37);
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (38, 'http://' , 38, 38, 38);
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (39, 'https://', 39, 39, 39);
INSERT INTO offtheshelf.photo(id_photo, photo_image, id_book, id_user, id_admin) VALUES (40, 'https://', 40, 40, 40);

/*Book_Author*/
/*(id_book, id_author)*/
/*40*/
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (1 ,1 );
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (2 ,2 );
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (3 ,3 );
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (4 ,4 );
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (5 ,5 );
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (6 ,6 );
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (7 ,7 );
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (8 ,8 );
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (9 ,9 );
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (10,10);
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (11,11);
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (12,12);
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (13,13);
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (14,14);
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (15,15);
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (16,16);
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (17,17);
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (18,18);
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (19,19);
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (20,20);
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (21,1 );
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (22,2 );
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (23,3 );
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (24,4 );
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (25,5 );
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (26,6 );
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (27,7 );
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (28,8 );
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (29,9 );
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (30,10);
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (31,11);
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (32,12);
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (33,13);
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (34,14);
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (35,15);
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (36,16);
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (37,17);
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (38,18);
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (39,19);
INSERT INTO offtheshelf.book_author(id_book, id_author) VALUES (40,20);

/*Book_Collection*/
/*(id_book, id_collections)*/
/*40*/
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (1 ,1 );
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (2 ,2 );
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (3 ,3 );
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (4 ,4 );
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (5 ,5 );
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (6 ,6 );
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (7 ,7 );
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (8 ,8 );
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (9 ,9 );
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (10,10);
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (11,11);
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (12,12);
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (13,13);
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (14,14);
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (15,15);
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (16,16);
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (17,17);
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (18,18);
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (19,19);
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (20,20);
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (21,1 );
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (22,2 );
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (23,3 );
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (24,4 );
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (25,5 );
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (26,6 );
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (27,7 );
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (28,8 );
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (29,9 );
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (30,10);
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (31,11);
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (32,12);
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (33,13);
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (34,14);
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (35,15);
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (36,16);
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (37,17);
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (38,18);
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (39,19);
INSERT INTO offtheshelf.book_collection(id_book, id_collections) VALUES (40,20);

/*Review*/
/*(id_review, rating, comment, review_date, id_book, id_user)*/
/*40*/
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (1 , 2, 'Mauris nulla. Integer urna. Vivamus molestie dapibus ligula. Aliquam erat volutpat. Nulla dignissim. Maecenas ornare egestas ligula. Nullam feugiat placerat'                                                                                                                                                                                                     , '2022-03-11 08:27:08  +8:00', 1 , 1 );
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (2 , 3, 'neque. Sed eget lacus. Mauris non dui nec urna suscipit nonummy. Fusce fermentum fermentum arcu. Vestibulum'                                                                                                                                                                                                                                                      , '2022-12-23 23:36:01 +1:00' , 2 , 2 );
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (3 , 3, 'lorem, auctor quis, tristique ac, eleifend vitae, erat. Vivamus nisi. Mauris nulla. Integer urna. Vivamus molestie dapibus ligula. Aliquam erat volutpat. Nulla dignissim. Maecenas ornare egestas ligula. Nullam feugiat placerat velit. Quisque varius. Nam porttitor scelerisque neque. Nullam'                                                                , '2022-11-17 23:02:59  +9:00', 3 , 3 );
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (4 , 1, 'sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Mauris ut quam vel sapien imperdiet ornare. In faucibus. Morbi vehicula. Pellentesque tincidunt tempus risus. Donec egestas. Duis ac arcu. Nunc mauris. Morbi non sapien molestie orci tincidunt adipiscing. Mauris molestie pharetra nibh. Aliquam ornare, libero at auctor ullamcorper,', '2023-03-01 04:41:22  +7:00', 4 , 4 );
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (5 , 4, 'malesuada fringilla est. Mauris eu turpis. Nulla aliquet. Proin velit. Sed malesuada augue ut lacus. Nulla tincidunt, neque vitae semper egestas, urna justo faucibus lectus, a sollicitudin orci sem eget massa. Suspendisse eleifend. Cras sed leo. Cras vehicula aliquet libero. Integer in magna. Phasellus'                                                  , '2023-05-03 19:57:31 +1:00' , 5 , 5 );
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (6 , 2, 'mattis semper, dui lectus rutrum urna, nec luctus felis purus ac tellus. Suspendisse sed dolor. Fusce mi lorem, vehicula et, rutrum eu, ultrices sit amet, risus. Donec nibh enim, gravida sit amet, dapibus id, blandit at, nisi. Cum sociis'                                                                                                                    , '2022-03-04 22:39:46 +5:00' , 6 , 6 );
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (7 , 1, 'Cras convallis convallis dolor. Quisque tincidunt pede ac urna. Ut tincidunt vehicula risus. Nulla eget metus eu erat'                                                                                                                                                                                                                                            , '2023-02-25 10:52:24 +1:00' , 7 , 7 );
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (8 , 3, 'eget massa. Suspendisse eleifend. Cras sed leo. Cras vehicula aliquet libero. Integer in magna. Phasellus dolor elit, pellentesque a, facilisis non, bibendum sed, est. Nunc laoreet lectus quis massa. Mauris'                                                                                                                                                   , '2023-03-07 00:09:53 +2:00' , 8 , 8 );
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (9 , 1, 'magna. Phasellus dolor elit, pellentesque a, facilisis non, bibendum sed,'                                                                                                                                                                                                                                                                                        , '2023-03-24 22:41:05 +2:00' , 9 , 9 );
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (10, 0, 'nec luctus felis purus ac tellus. Suspendisse sed dolor. Fusce mi lorem, vehicula et, rutrum eu, ultrices sit amet, risus. Donec nibh enim,'                                                                                                                                                                                                                      , '2023-09-14 00:05:19  +8:00', 10, 10);
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (11, 4, 'vitae diam. Proin dolor. Nulla semper tellus id nunc interdum feugiat. Sed nec metus facilisis lorem tristique aliquet. Phasellus fermentum convallis ligula. Donec luctus aliquet odio. Etiam ligula tortor, dictum eu, placerat eget, venenatis a, magna. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.'                                            , '2021-12-31 06:21:17  +1:00', 11, 11);
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (12, 5, 'velit. Sed malesuada augue ut lacus. Nulla tincidunt, neque vitae semper egestas, urna justo faucibus lectus,'                                                                                                                                                                                                                                                    , '2023-06-05 06:09:36 +3:00' , 12, 12);
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (13, 1, 'ipsum. Curabitur consequat, lectus sit amet luctus vulputate, nisi sem semper erat, in consectetuer ipsum nunc id enim. Curabitur massa. Vestibulum accumsan neque et nunc. Quisque ornare tortor at risus. Nunc ac sem ut dolor dapibus gravida. Aliquam tincidunt, nunc ac mattis ornare, lectus ante dictum mi, ac mattis'                                     , '2021-12-25 20:24:57  +6:00', 13, 13);
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (14, 1, 'Cras dictum ultricies ligula. Nullam enim. Sed nulla ante, iaculis nec, eleifend'                                                                                                                                                                                                                                                                                 , '2021-12-09 03:57:43 +1:00' , 14, 14);
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (15, 3, 'egestas nunc sed libero. Proin sed turpis nec mauris blandit mattis.'                                                                                                                                                                                                                                                                                             , '2023-03-14 12:21:30  +6:00', 15, 15);
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (16, 4, 'Donec tincidunt. Donec vitae erat vel pede blandit congue. In scelerisque scelerisque dui. Suspendisse ac metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc nulla vulputate dui, nec tempus mauris'                                                                                                                                  , '2022-03-24 05:22:52 +10:00', 16, 16);
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (17, 2, 'erat volutpat. Nulla facilisis. Suspendisse commodo tincidunt nibh. Phasellus nulla. Integer vulputate, risus a ultricies adipiscing, enim mi tempor lorem, eget'                                                                                                                                                                                                 , '2022-02-19 03:49:33 +11:00', 17, 17);
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (18, 4, 'tempus scelerisque, lorem ipsum sodales purus, in molestie tortor nibh sit amet orci. Ut sagittis lobortis mauris. Suspendisse aliquet molestie tellus. Aenean egestas hendrerit neque. In ornare sagittis felis. Donec tempor, est ac mattis semper, dui lectus rutrum urna, nec luctus felis purus ac tellus. Suspendisse sed dolor. Fusce'                     , '2021-12-31 05:55:52  +9:00', 18, 18);
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (19, 3, 'Duis gravida. Praesent eu nulla at sem molestie sodales. Mauris blandit'                                                                                                                                                                                                                                                                                          , '2023-10-12 00:16:35 +16:00', 19, 19);
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (20, 4, 'quam quis diam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Fusce aliquet magna a neque. Nullam ut nisi a odio semper cursus. Integer mollis. Integer tincidunt aliquam arcu.'                                                                                                                                  , '2021-11-01 15:40:53 +20:00', 20, 20);
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (21, 1, 'Curae Phasellus ornare. Fusce mollis. Duis sit amet diam eu dolor egestas rhoncus. Proin nisl sem, consequat nec, mollis vitae, posuere at, velit. Cras lorem lorem, luctus ut, pellentesque eget, dictum placerat, augue. Sed molestie. Sed id risus'                                                                                                            , '2023-07-28 06:13:33  -7:00', 21, 21);
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (22, 5, 'fringilla euismod enim. Etiam gravida molestie arcu. Sed eu nibh vulputate mauris sagittis placerat. Cras dictum ultricies ligula. Nullam enim. Sed nulla ante, iaculis nec, eleifend non, dapibus rutrum,'                                                                                                                                                       , '2022-08-05 02:17:19 -1:00' , 22, 22);
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (23, 3, 'dictum eleifend, nunc risus varius orci, in consequat enim diam vel arcu. Curabitur ut odio vel est tempor bibendum. Donec felis orci, adipiscing non, luctus sit amet, faucibus ut, nulla. Cras eu tellus eu augue porttitor interdum.'                                                                                                                          , '2022-07-28 19:03:13  -7:00', 23, 23);
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (24, 2, 'posuere cubilia Curae Phasellus ornare. Fusce mollis. Duis sit amet diam eu dolor egestas rhoncus. Proin nisl sem, consequat'                                                                                                                                                                                                                                     , '2023-04-03 17:23:58 -9:00' , 24, 24);
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (25, 1, 'vitae semper egestas, urna justo faucibus lectus, a sollicitudin orci sem eget massa. Suspendisse eleifend. Cras sed leo. Cras vehicula aliquet libero. Integer in magna.'                                                                                                                                                                                        , '2022-11-04 19:43:21 -8:00' , 25, 25);
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (26, 4, 'a, scelerisque sed, sapien. Nunc pulvinar arcu et pede. Nunc sed orci lobortis augue scelerisque mollis. Phasellus'                                                                                                                                                                                                                                               , '2023-07-13 00:15:18  -6:00', 26, 26);
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (27, 5, 'a, auctor non, feugiat nec, diam. Duis mi enim, condimentum eget, volutpat ornare, facilisis eget, ipsum. Donec sollicitudin adipiscing ligula. Aenean gravida nunc sed pede. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin vel arcu eu odio tristique pharetra. Quisque ac libero nec ligula consectetuer'         , '2021-12-05 06:50:04 -2:00' , 27, 27);
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (28, 5, 'elementum at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et pede. Nunc sed orci lobortis'                                                                                                                                                                                                                                                             , '2023-05-14 09:06:03 -2:00' , 28, 28);
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (29, 3, 'odio. Phasellus at augue id ante dictum cursus. Nunc mauris elit, dictum eu, eleifend nec, malesuada ut, sem. Nulla interdum. Curabitur dictum. Phasellus in felis. Nulla tempor'                                                                                                                                                                                 , '2023-03-31 15:25:17  -5:00', 29, 29);
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (30, 5, 'massa. Suspendisse eleifend. Cras sed leo. Cras vehicula aliquet libero. Integer in magna. Phasellus dolor elit, pellentesque a, facilisis non, bibendum sed, est. Nunc laoreet lectus quis massa. Mauris vestibulum, neque sed dictum eleifend, nunc risus varius orci, in consequat'                                                                            , '2022-09-18 04:02:37  -5:00', 30, 30);
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (31, 0, 'vitae dolor. Donec fringilla. Donec feugiat metus sit amet ante. Vivamus non lorem vitae odio sagittis semper. Nam tempor diam dictum sapien. Aenean massa. Integer vitae nibh. Donec est mauris, rhoncus id, mollis'                                                                                                                                             , '2023-02-10 21:45:00 -11:00', 31, 31);
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (32, 2, 'euismod mauris eu elit. Nulla facilisi. Sed neque. Sed eget lacus. Mauris non'                                                                                                                                                                                                                                                                                    , '2023-07-06 00:11:38  -2:00', 32, 32);
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (33, 3, 'nisl. Maecenas malesuada fringilla est. Mauris eu turpis. Nulla aliquet. Proin velit. Sed malesuada augue ut lacus.'                                                                                                                                                                                                                                              , '2022-07-13 22:05:06  -5:00', 33, 33);
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (34, 2, 'eget, volutpat ornare, facilisis eget, ipsum. Donec sollicitudin adipiscing ligula. Aenean gravida nunc sed pede. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin vel arcu eu odio tristique pharetra. Quisque ac libero nec ligula consectetuer rhoncus. Nullam'                                                     , '2023-05-30 19:47:35  -6:00', 34, 34);
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (35, 1, 'erat vel pede blandit congue. In scelerisque scelerisque dui. Suspendisse ac metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc nulla vulputate dui, nec tempus mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae'                                                                                                           , '2022-11-17 05:47:53 -11:00', 35, 35);
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (36, 5, 'Nullam scelerisque neque sed sem egestas blandit. Nam nulla magna, malesuada vel, convallis in, cursus et, eros. Proin ultrices. Duis volutpat nunc sit amet metus. Aliquam erat volutpat. Nulla facilisis. Suspendisse commodo tincidunt'                                                                                                                        , '2022-02-08 22:12:40 -10:00', 36, 36);
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (37, 3, 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin vel nisl. Quisque fringilla euismod enim. Etiam gravida molestie arcu. Sed eu nibh vulputate mauris sagittis placerat. Cras dictum ultricies ligula. Nullam enim. Sed nulla ante, iaculis nec, eleifend'                                                              , '2022-11-06 08:06:32 -11:00', 37, 37);
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (38, 3, 'et netus et malesuada fames ac turpis egestas. Aliquam fringilla cursus purus. Nullam scelerisque neque sed sem egestas blandit. Nam nulla magna, malesuada vel, convallis in, cursus et, eros. Proin ultrices.'                                                                                                                                                  , '2023-04-28 12:05:40  -3:00', 38, 38);
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (39, 2, 'Donec felis orci, adipiscing non, luctus sit amet, faucibus ut, nulla. Cras eu tellus eu augue porttitor interdum. Sed auctor odio a purus. Duis elementum, dui quis accumsan convallis, ante lectus convallis est, vitae sodales nisi magna sed dui. Fusce aliquam, enim'                                                                                        , '2022-05-28 18:13:39  -9:00', 39, 39);
INSERT INTO offtheshelf.review(id_review, rating, comment, review_date, id_book, id_user) VALUES (40, 1, 'ornare, elit elit fermentum risus, at fringilla purus mauris a nunc. In at pede. Cras vulputate velit eu sem. Pellentesque ut ipsum ac mi eleifend egestas. Sed pharetra, felis eget varius ultrices, mauris ipsum porta elit, a feugiat tellus lorem eu metus.'                                                                                                  , '2023-10-10 02:11:49 -10:00', 40, 40);

/*Purchase_book*/
/*(id_purchase, id_book)*/
/*40*/
INSERT INTO offtheshelf.purchase_book(id_purchase, id_book) VALUES (1 ,1 );
INSERT INTO offtheshelf.purchase_book(id_purchase, id_book) VALUES (2 ,2 );
INSERT INTO offtheshelf.purchase_book(id_purchase, id_book) VALUES (3 ,3 );
INSERT INTO offtheshelf.purchase_book(id_purchase, id_book) VALUES (4 ,4 );
INSERT INTO offtheshelf.purchase_book(id_purchase, id_book) VALUES (5 ,5 );
INSERT INTO offtheshelf.purchase_book(id_purchase, id_book) VALUES (6 ,6 );
INSERT INTO offtheshelf.purchase_book(id_purchase, id_book) VALUES (7 ,7 );
INSERT INTO offtheshelf.purchase_book(id_purchase, id_book) VALUES (8 ,8 );
INSERT INTO offtheshelf.purchase_book(id_purchase, id_book) VALUES (9 ,9 );
INSERT INTO offtheshelf.purchase_book(id_purchase, id_book) VALUES (10,10);
INSERT INTO offtheshelf.purchase_book(id_purchase, id_book) VALUES (1 ,11);
INSERT INTO offtheshelf.purchase_book(id_purchase, id_book) VALUES (2 ,12);
INSERT INTO offtheshelf.purchase_book(id_purchase, id_book) VALUES (3 ,13);
INSERT INTO offtheshelf.purchase_book(id_purchase, id_book) VALUES (4 ,14);
INSERT INTO offtheshelf.purchase_book(id_purchase, id_book) VALUES (5 ,15);
INSERT INTO offtheshelf.purchase_book(id_purchase, id_book) VALUES (6 ,16);
INSERT INTO offtheshelf.purchase_book(id_purchase, id_book) VALUES (7 ,17);
INSERT INTO offtheshelf.purchase_book(id_purchase, id_book) VALUES (8 ,18);
INSERT INTO offtheshelf.purchase_book(id_purchase, id_book) VALUES (9 ,19);
INSERT INTO offtheshelf.purchase_book(id_purchase, id_book) VALUES (10,20);

/*Delivery*/
/*(id_delivery, arrival, delivery_address, cost, id_purchase)*/
/*40*/
INSERT INTO offtheshelf.delivery(id_delivery, arrival, delivery_address, cost, id_purchase) VALUES (1 , '2023-05-18 03:50:35  +0:00', '335-2063 Ligula. St.'        , '131.96', 1 );
INSERT INTO offtheshelf.delivery(id_delivery, arrival, delivery_address, cost, id_purchase) VALUES (2 , '2023-09-09 10:14:51  +4:00', '596-213 In St.'              , '104.86', 2 );
INSERT INTO offtheshelf.delivery(id_delivery, arrival, delivery_address, cost, id_purchase) VALUES (3 , '2023-06-28 03:00:56  +9:00', '432-7822 Parturient Av.'     , '104.80', 3 );
INSERT INTO offtheshelf.delivery(id_delivery, arrival, delivery_address, cost, id_purchase) VALUES (4 , '2022-08-27 12:03:07  +3:00', '979-3302 Suspendisse Road'   , '174.59', 4 );
INSERT INTO offtheshelf.delivery(id_delivery, arrival, delivery_address, cost, id_purchase) VALUES (5 , '2023-01-26 05:53:02 +10:00', '257-1328 Sed Road'           , '156.08', 5 );
INSERT INTO offtheshelf.delivery(id_delivery, arrival, delivery_address, cost, id_purchase) VALUES (6 , '2022-10-26 04:46:01  +4:00', 'Ap #490-8898 Eleifend Ave'   , '54.71' , 6 );
INSERT INTO offtheshelf.delivery(id_delivery, arrival, delivery_address, cost, id_purchase) VALUES (7 , '2023-02-18 11:06:34  +1:00', 'Ap #132-901 Pellentesque St.', '146.63', 7 );
INSERT INTO offtheshelf.delivery(id_delivery, arrival, delivery_address, cost, id_purchase) VALUES (8 , '2023-02-16 00:21:30 +13:00', 'Ap #912-1067 Tempor Av.'     , '68.53' , 8 );
INSERT INTO offtheshelf.delivery(id_delivery, arrival, delivery_address, cost, id_purchase) VALUES (9 , '2023-07-08 20:19:33  +1:00', 'Ap #336-634 Pede, Street'    , '193.12', 9 );
INSERT INTO offtheshelf.delivery(id_delivery, arrival, delivery_address, cost, id_purchase) VALUES (10, '2023-07-13 04:37:46  +0:00', '385-9529 Placerat Road'      , '122.76', 10);
INSERT INTO offtheshelf.delivery(id_delivery, arrival, delivery_address, cost, id_purchase) VALUES (11, '2022-03-11 07:58:29  -7:00', '165-2173 Tempor Rd.'         , '199.59', 1 );
INSERT INTO offtheshelf.delivery(id_delivery, arrival, delivery_address, cost, id_purchase) VALUES (12, '2023-10-10 12:02:02  -4:00', 'Ap #330-9734 Etiam St.'      , '121.40', 2 );
INSERT INTO offtheshelf.delivery(id_delivery, arrival, delivery_address, cost, id_purchase) VALUES (13, '2022-11-14 16:39:11  -6:00', 'Ap #325-4858 Mauris Ave'     , '121.18', 3 );
INSERT INTO offtheshelf.delivery(id_delivery, arrival, delivery_address, cost, id_purchase) VALUES (14, '2022-07-26 11:43:51 -12:00', '441 Ut, Road'                , '111.12', 4 );
INSERT INTO offtheshelf.delivery(id_delivery, arrival, delivery_address, cost, id_purchase) VALUES (15, '2023-09-16 12:18:09 -21:00', '7295 Semper Avenue'          , '155.91', 5 );
INSERT INTO offtheshelf.delivery(id_delivery, arrival, delivery_address, cost, id_purchase) VALUES (16, '2023-06-23 06:42:12  -6:00', '2684 Sit St.'                , '137.35', 6 );
INSERT INTO offtheshelf.delivery(id_delivery, arrival, delivery_address, cost, id_purchase) VALUES (17, '2021-11-14 07:56:01 -10:00', '787-9562 Elementum St.'      , '78.51' , 7 );
INSERT INTO offtheshelf.delivery(id_delivery, arrival, delivery_address, cost, id_purchase) VALUES (18, '2022-09-16 13:43:16  -1:00', '6933 Lorem. Av.'             , '165.48', 8 );
INSERT INTO offtheshelf.delivery(id_delivery, arrival, delivery_address, cost, id_purchase) VALUES (19, '2022-12-06 00:43:44  -7:00', '171-2962 Molestie Avenue'    , '179.91', 9 );
INSERT INTO offtheshelf.delivery(id_delivery, arrival, delivery_address, cost, id_purchase) VALUES (20, '2023-10-05 07:55:36 -13:00', 'Ap #868-8945 Est Rd.'        , '100.35', 10);

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
