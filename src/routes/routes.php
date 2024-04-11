<?php

use controller\CartController;
use controller\CatalogController;
use controller\AuthenticationController;
use controller\OrderController;
use controller\ProfileController;
use controller\RegistrationController;
use view\Renderer;

$app->registerGetRoute("/404", function() {
    $renderer = new Renderer();
    require_once $renderer->render("404.phtml");
});

$app->registerGetRoute(["/home", "/"], function() {
    $renderer = new Renderer();
    require_once $renderer->render("home.phtml");
});

$app->registerGetRoute("/register", [RegistrationController::class, "view"]);
$app->registerPostRoute("/register", [RegistrationController::class, "post"]);

$app->registerGetRoute("/login", [AuthenticationController::class, "view"]);
$app->registerPostRoute("/login", [AuthenticationController::class, "login"]);
$app->registerPostRoute("/logout", [AuthenticationController::class, "logout"]);

$app->registerGetRoute("/profile", [ProfileController::class, "view"]);

$app->registerGetRoute(
    ["/profile/edit", "/profile/edit?"],
    [ProfileController::class, "getEditDescription"]
);

$app->registerPostRoute(
    ["/profile/edit", "/profile/edit?"],
    [ProfileController::class, "postEditDescription"]
);


$app->registerGetRoute("/catalog", [CatalogController::class, "view"]);
$app->registerPostRoute("/catalog/add-to-cart", [CatalogController::class, "add"]);

$app->registerGetRoute("/cart", [CartController::class, "view"]);

$app->registerGetRoute("/checkout", [OrderController::class, "view"]);
