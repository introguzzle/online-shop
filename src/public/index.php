<?php

require_once "./../Autoloader.php";
require_once "./../Application.php";
require_once "./../reflector/Resolver.php";

Autoloader::register();
$app = new Application();

require_once "./../routes/routes.php";

$app->run();