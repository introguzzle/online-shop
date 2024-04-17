<?php

use core\container\Container;

use repository\BookRepository;
use repository\CartBookRepository;
use repository\CartRepository;
use repository\OrderRepository;
use repository\ProfileRepository;
use repository\UserRepository;

use service\authentication\AuthenticationService;
use service\authentication\SessionAuthenticationService;
use service\CartService;
use service\CatalogService;
use service\LoginService;
use service\OrderService;
use service\ProfileService;
use service\RegistrationService;

use validation\LoginValidator;
use validation\OrderValidator;
use validation\RegistrationValidator;

return [
    RegistrationValidator::class => function(Container $container) {
        return new RegistrationValidator($container->get(UserRepository::class));
    },

    LoginValidator::class => function(Container $container) {
        return new LoginValidator();
    },

    AuthenticationService::class => function(Container $container) {
        return new SessionAuthenticationService(
            $container->get(UserRepository::class)
        );
    },

    LoginService::class => function(Container $container) {
        return new LoginService(
            $container->get(AuthenticationService::class),
            $container->get(UserRepository::class),
            $container->get(LoginValidator::class)
        );
    },

    RegistrationService::class => function(Container $container) {
        return new RegistrationService(
            $container->get(UserRepository::class),
            $container->get(ProfileService::class),
            $container->get(RegistrationValidator::class)
        );
    },

    CartService::class => function(Container $container) {
        return new CartService(
            $container->get(CartRepository::class),
            $container->get(CartBookRepository::class),
            $container->get(BookRepository::class)
        );
    },

    CatalogService::class => function(Container $container) {
        return new CatalogService(
            $container->get(BookRepository::class)
        );
    },

    OrderService::class => function(Container $container) {
        return new OrderService(
            $container->get(OrderRepository::class),
            $container->get(CartRepository::class),
            $container->get(OrderValidator::class)
        );
    },

    ProfileService::class => function(Container $container) {
        return new ProfileService(
            $container->get(ProfileRepository::class)
        );
    },
];