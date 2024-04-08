<?php

use controller\CatalogController;
use controller\HomeController;
use controller\AuthenticationController;
use controller\ProfileController;
use controller\RegistrationController;
use service\SessionAuthenticationService;

$app->registerGetRoute("/register", RegistrationController::class, 'get');
$app->registerPostRoute("/register", RegistrationController::class, 'post');

$app->registerGetRoute("/login", AuthenticationController::class, "get");
$app->registerPostRoute("/login", AuthenticationController::class, "login");
$app->registerPostRoute("/logout", AuthenticationController::class, "logout");

$app->registerGetRoute("/home", HomeController::class, "get");

$app->registerGetRoute("/profile", ProfileController::class, "get");

$app->registerGetRoute("/catalog", CatalogController::class, "get");
