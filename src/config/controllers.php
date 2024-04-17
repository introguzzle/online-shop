<?php

use core\container\Container;

use controller\CartController;
use controller\CatalogController;
use controller\OrderController;
use controller\ProfileController;
use controller\UserController;

use service\CartService;
use service\CatalogService;
use service\LoginService;
use service\OrderService;
use service\ProfileService;
use service\RegistrationService;

return [
    UserController::class => function (Container $container) {
        return new UserController(
            $container->get(LoginService::class),
            $container->get(RegistrationService::class)
        );
    },

    ProfileController::class => function (Container $container) {
        return new ProfileController(
            $container->get(ProfileService::class)
        );
    },

    OrderController::class => function(Container $container) {
        return new OrderController(
            $container->get(OrderService::class)
        );
    },

    CatalogController::class => function(Container $container) {
        return new CatalogController(
            $container->get(CatalogService::class)
        );
    },

    CartController::class => function(Container $container) {
        return new CartController(
            $container->get(CartService::class)
        );
    }
];