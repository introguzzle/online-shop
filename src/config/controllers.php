<?php

use core\container\Container;

use controller\CartController;
use controller\CatalogController;
use controller\OrderController;
use controller\ProfileController;
use controller\UserController;

use service\authentication\AuthenticationService;
use service\CartService;
use service\CatalogService;
use service\OrderService;
use service\ProfileService;
use service\RegistrationService;
use validation\LoginValidator;
use validation\OrderValidator;
use validation\RegistrationValidator;
use validation\ReviewValidator;

return [
    UserController::class => function (Container $container) {
        return new UserController(
            $container->get(AuthenticationService::class),
            $container->get(RegistrationService::class),
            $container->get(LoginValidator::class),
            $container->get(RegistrationValidator::class)
        );
    },

    ProfileController::class => function (Container $container) {
        return new ProfileController(
            $container->get(ProfileService::class)
        );
    },

    OrderController::class => function(Container $container) {
        return new OrderController(
            $container->get(OrderService::class),
            $container->get(OrderValidator::class)
        );
    },

    CatalogController::class => function(Container $container) {
        return new CatalogController(
            $container->get(CatalogService::class),
            $container->get(ReviewValidator::class)
        );
    },

    CartController::class => function(Container $container) {
        return new CartController(
            $container->get(CartService::class)
        );
    }
];