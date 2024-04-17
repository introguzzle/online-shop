<?php

use core\Application;
use core\Autoloader;
use core\container\DIContainer;
use core\Logger;

require_once "./../core/Application.php";
require_once "./../core/Autoloader.php";
require_once "./../reflector/Resolver.php";

$repositories = require_once "./../config/repositories.php";
$services = require_once "./../config/services.php";
$controllers = require_once "./../config/controllers.php";

Autoloader::register();

$container = new DIContainer($repositories, $services, $controllers);
$logger = new Logger();

$app = new Application($container, $logger);

require_once "./../routes/routes.php";

$app->run();