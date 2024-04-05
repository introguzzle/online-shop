<?php

use controller\LoginController;
use controller\RegistrationController;

$app->get("/register", RegistrationController::class, 'get');
$app->post("/register", RegistrationController::class, 'post');

$app->get("/login", LoginController::class, "get");
$app->post("/login", LoginController::class, "post");
