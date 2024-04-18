<?php

use core\container\Container;

use repository\BookRepository;
use repository\CartBookRepository;
use repository\CartRepository;
use repository\connection\Connection;
use repository\connection\DefaultConnection;
use repository\hydrator\DefaultHydrator;
use repository\hydrator\Hydrator;
use repository\OrderRepository;
use repository\ProfileRepository;
use repository\ReviewRepository;
use repository\UserRepository;

return [
    Connection::class => function(Container $container) {
        return new DefaultConnection();
    },

    Hydrator::class => function(Container $container) {
        return new DefaultHydrator();
    },

    UserRepository::class => function(Container $container) {
        return new UserRepository(
            $container->get(Connection::class),
            $container->get(Hydrator::class)
        );
    },

    ProfileRepository::class => function(Container $container) {
        return new ProfileRepository(
            $container->get(Connection::class),
            $container->get(Hydrator::class)
        );
    },

    OrderRepository::class => function(Container $container) {
        return new OrderRepository(
            $container->get(Connection::class),
            $container->get(Hydrator::class)
        );
    },

    CartRepository::class => function(Container $container) {
        return new CartRepository(
            $container->get(Connection::class),
            $container->get(Hydrator::class),
            $container->get(BookRepository::class)
        );
    },

    BookRepository::class => function(Container $container) {
        return new BookRepository(
            $container->get(Connection::class),
            $container->get(Hydrator::class)
        );
    },

    CartBookRepository::class => function(Container $container) {
        return new CartBookRepository(
            $container->get(Connection::class),
            $container->get(Hydrator::class),
            $container->get(CartRepository::class),
            $container->get(BookRepository::class)
        );
    },

    ReviewRepository::class => function(Container $container) {
        return new ReviewRepository(
            $container->get(Connection::class),
            $container->get(Hydrator::class)
        );
    }
];