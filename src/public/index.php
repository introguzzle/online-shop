<?php

require_once "./../Autoloader.php";
require_once "./../Application.php";

Autoloader::register();
$app = new Application();

require_once "./../routes/routes.php";

$app->run();