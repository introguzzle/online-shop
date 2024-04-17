<?php

use controller\CartController;
use controller\CatalogController;
use controller\UserController;
use controller\OrderController;
use controller\ProfileController;
use view\Renderer;

$app->registerGetRoute("/404", function() {
    $renderer = new Renderer();
    require_once $renderer->render("404.phtml");
});

$app->registerGetRoute(["/home", "/"], function() {
    $renderer = new Renderer();
    require_once $renderer->render("home.phtml");
});

$app->registerGetRoute("/register", [UserController::class, "registrationView"]);
$app->registerPostRoute("/register", [UserController::class, "register"]);

$app->registerGetRoute("/login", [UserController::class, "loginView"]);
$app->registerPostRoute("/login", [UserController::class, "login"]);
$app->registerPostRoute("/logout", [UserController::class, "logout"]);

$app->registerGetRoute("/profile", [ProfileController::class, "view"]);

$app->registerGetRoute(
    ["/profile/edit", "/profile/edit?"],
    [ProfileController::class, "getDescriptionEdit"]
);

$app->registerPostRoute(
    ["/profile/edit", "/profile/edit?"],
    [ProfileController::class, "postDescriptionEdit"]
);


$app->registerGetRoute("/catalog", [CatalogController::class, "view"]);
$app->registerPostRoute("/catalog/add-to-cart", [CartController::class, "addFromCatalog"]);

$app->registerGetRoute("/cart", [CartController::class, "view"]);
$app->registerPostRoute("/cart/add", [CartController::class, "add"]);
$app->registerPostRoute("/cart/remove", [CartController::class, "remove"]);

$app->registerGetRoute("/checkout", [OrderController::class, "view"]);
$app->registerPostRoute("/submit-order", [OrderController::class, "processOrder"]);
