<?php

use core\container\Container;

use repository\BookRepository;
use repository\CartBookRepository;
use repository\CartRepository;
use repository\hydrator\DefaultHydrator;
use repository\hydrator\Hydrator;
use repository\OrderRepository;
use repository\ProfileRepository;
use repository\UserRepository;

return [
    Hydrator::class => function(Container $container) {
        return new DefaultHydrator();
    },

    UserRepository::class => function(Container $container) {
        return new UserRepository($container->get(Hydrator::class));
    },

    ProfileRepository::class => function(Container $container) {
        return new ProfileRepository($container->get(Hydrator::class));
    },

    OrderRepository::class => function(Container $container) {
        return new OrderRepository($container->get(Hydrator::class));
    },

    CartRepository::class => function(Container $container) {
        return new CartRepository(
            $container->get(Hydrator::class),
            $container->get(BookRepository::class)
        );
    },

    BookRepository::class => function(Container $container) {
        return new BookRepository($container->get(Hydrator::class));
    },

    CartBookRepository::class => function(Container $container) {
        return new CartBookRepository(
            $container->get(Hydrator::class),
            $container->get(CartRepository::class),
            $container->get(BookRepository::class)
        );
    },
];