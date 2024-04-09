<?php

use controller\CartController;
use controller\CatalogController;
use controller\ErrorController;
use controller\HomeController;
use controller\AuthenticationController;
use controller\ProfileController;
use controller\RegistrationController;

$app->registerGetRoute("/404", ErrorController::class, "view");

$app->registerGetRoute("/register", RegistrationController::class, "view");
$app->registerPostRoute("/register", RegistrationController::class, "post");

$app->registerGetRoute("/login", AuthenticationController::class, "view");
$app->registerPostRoute("/login", AuthenticationController::class, "login");
$app->registerPostRoute("/logout", AuthenticationController::class, "logout");

$app->registerGetRoute("/home", HomeController::class, "view");
$app->registerGetRoute("/", HomeController::class, "view");

$app->registerGetRoute("/profile", ProfileController::class, "view");
$app->registerGetRoute("/profile/edit", ProfileController::class, "getEditDescription");
$app->registerGetRoute("/profile/edit?", ProfileController::class, "getEditDescription");

$app->registerPostRoute("/profile/edit", ProfileController::class, "postEditDescription");
$app->registerPostRoute("/profile/edit?", ProfileController::class, "postEditDescription");


$app->registerGetRoute("/catalog", CatalogController::class, "view");
$app->registerPostRoute("/catalog/add-to-cart", CatalogController::class, "add");

$app->registerGetRoute("/cart", CartController::class, "view");
