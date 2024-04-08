CREATE TABLE users (
                       id serial primary key ,
                       name varchar(255) not null,
                       email varchar(255) not null unique ,
                       password varchar(1024) not null ,
                       created_at timestamp,
                       updated_at timestamp
);

CREATE TABLE profiles (
                          id serial primary key ,
                          user_id bigint references users(id),
                          avatar_url varchar(255) ,
                          description text
);

CREATE TABLE books (
                       id          serial primary key,
                       name        varchar(255),
                       author      varchar(255),
                       description varchar(255),
                       price       bigint
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

CREATE TABLE carts (
                       id serial primary key ,
                       user_id bigint references users(id),
                       total_price bigint
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

