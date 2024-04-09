CREATE TABLE roles (
                       id serial primary key ,
                       name varchar(255) not null unique
);

INSERT INTO roles(name) VALUES ('USER');
INSERT INTO roles(name) VALUES ('ADMIN');

CREATE TABLE users (
                       id serial primary key ,
                       name varchar(255) not null,
                       email varchar(255) not null unique ,
                       password varchar(1024) not null ,
                       created_at timestamp,
                       updated_at timestamp,
                       role_id bigint not null REFERENCES roles(id)
);

CREATE TABLE carts (
                       id serial primary key ,
                       user_id bigint not null REFERENCES users(id) unique
);

CREATE TABLE profiles (
                          id serial primary key ,
                          user_id bigint references users(id) unique,
                          avatar_url varchar(255) ,
                          description text
);

CREATE TABLE books (
                       id          serial primary key,
                       name        varchar(255),
                       author      varchar(255),
                       description varchar(255),
                       year        bigint,
                       price       bigint,
                       image_url   varchar(255)
);

CREATE TABLE genres (
                        id serial primary key ,
                        name varchar(255)
);

CREATE TABLE book_genre (
                            id serial primary key,
                            book_id bigint references books(id),
                            genre_id bigint references genres(id)
);

CREATE TABLE user_book (
                           id serial primary key ,
                           user_id bigint references users(id),
                           book_id bigint references books(id)
);

CREATE TABLE cart_book (
                           id serial primary key,
                           cart_id bigint references carts(id),
                           book_id bigint references books(id)
);

CREATE TABLE orders (
                        id serial primary key ,
                        cart_id bigint references carts(id)
);

INSERT INTO books(name, author, description, year, price, image_url) VALUES ('Книга 1', 'Автор 1', 'Описание 1', '2010' , '200', 'https://i1.mybook.io/p/x756/book_covers/43/cc/43cc126f-275c-4a71-9d4a-2c44be44c657.jpg');
INSERT INTO books(name, author, description, year, price, image_url) VALUES ('Книга 2', 'Автор 2', 'Описание 2', '2020' , '300', 'https://i1.mybook.io/p/x756/book_covers/25/84/25849038-707d-43e5-8c9c-acff0024e6ca.jpg');
INSERT INTO books(name, author, description, year, price, image_url) VALUES ('Книга 3', 'Автор 3', 'Описание 3', '2045' , '400', 'https://i2.mybook.io/p/x756/book_covers/8f/30/8f30530d-f261-431c-9fdb-9d3e416ca2b0.jpg');
INSERT INTO books(name, author, description, year, price, image_url) VALUES ('Книга 4', 'Автор 4', 'Описание 4', '1999' , '500', 'https://i1.mybook.io/p/x756/book_covers/32/ec/32ecd8eb-4ecc-4cde-8146-ec1aa2e54e64.jpg');
INSERT INTO books(name, author, description, year, price, image_url) VALUES ('Книга 5', 'Автор 5', 'Описание 5', '3078' , '600', 'https://i2.mybook.io/p/x756/book_covers/a4/6a/a46a236b-a40c-46e6-a2a5-9e0f8695766c.jpg');
INSERT INTO books(name, author, description, year, price, image_url) VALUES ('Книга 6', 'Автор 6', 'Описание 6', '4102' , '700', 'https://i2.mybook.io/p/x756/book_covers/5d/e8/5de8aae0-686a-4dc8-ba3e-8a7cd92441ec.jpg');
INSERT INTO books(name, author, description, year, price, image_url) VALUES ('Книга 7', 'Автор 7', 'Описание 7', '1023' , '800', 'https://i2.mybook.io/p/x756/book_covers/dd/f4/ddf4ed57-7f52-4243-9465-f4ae2116d260.jpg');
