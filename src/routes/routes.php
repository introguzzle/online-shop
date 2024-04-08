<?php

use controller\CartController;
use controller\CatalogController;
use controller\HomeController;
use controller\AuthenticationController;
use controller\ProfileController;
use controller\RegistrationController;

$app->registerGetRoute("/register", RegistrationController::class, 'get');
$app->registerPostRoute("/register", RegistrationController::class, 'post');

$app->registerGetRoute("/login", AuthenticationController::class, "get");
$app->registerPostRoute("/login", AuthenticationController::class, "login");
$app->registerPostRoute("/logout", AuthenticationController::class, "logout");

$app->registerGetRoute("/home", HomeController::class, "get");
$app->registerGetRoute("/", HomeController::class, "get");

$app->registerGetRoute("/profile", ProfileController::class, "get");
$app->registerGetRoute("/profile/edit", ProfileController::class, "getEditDescription");
$app->registerGetRoute("/profile/edit?", ProfileController::class, "getEditDescription");

$app->registerPostRoute("/profile/edit", ProfileController::class, "postEditDescription");
$app->registerPostRoute("/profile/edit?", ProfileController::class, "postEditDescription");


$app->registerGetRoute("/catalog", CatalogController::class, "get");

$app->registerGetRoute("/cart", CartController::class, "get");