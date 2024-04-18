<?php

namespace core;

use controller\CatalogController;
use core\container\Container;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use service\authentication\Authentication;
use service\authentication\AuthenticationService;
use Throwable;
use util\NamingConventions;

class Application
{
    private array $routes = [];
    private Logger $logger;
    private Container $container;

    public function __construct(Container $container, Logger $logger)
    {
        $this->container = $container;
        $this->logger = $logger;
    }

    public function bootstrap(): void
    {
        Authentication::init($this->container->get(AuthenticationService::class));
    }

    /**
     * @throws ReflectionException
     */
    public function run(): void
    {
        $handler = $this->acquireHandler();
        $this->bootstrap();

        $instance = null;

        if (is_array($handler)) {
            $handler[0] = $this->container->get($handler[0]);

            $class = $this->acquireHandlerParameterClass($handler);

            if ($class !== null) {
                $instance = $this->provideInstance($class);
            }
        }

        $this->invokeHandler($handler, $instance);
    }

    private function invokeHandler(
        mixed $handler,
        mixed $instance = null
    ): void
    {
        try {
            if ($instance === null) {
                $handler();
            } else {
                $handler($instance);
            }

        } catch (Throwable $t) {
            $this->logger->error($t);
            $this->serverError();
        }
    }

    private function acquireHandler(): mixed
    {
        $requestUri = $_SERVER["REQUEST_URI"];

        if (preg_match('~^/catalog/(\d+)$~', $requestUri, $matches)) {
            $id = $matches[1];
            $_GET["id"] = $id;
            $this->registerGetRoute("/catalog/$id", [CatalogController::class, "viewBook"]);
        }

        $clientError = false;

        if (!array_key_exists($requestUri, $this->routes)) {
            $clientError = true;
        }

        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if (!isset($this->routes[$requestUri][$requestMethod])) {
            $clientError = true;
        }

        if ($clientError) {
            $this->clientError();
        }

        return $this->routes[$requestUri][$requestMethod];
    }

    /**
     * @throws ReflectionException
     */
    private function acquireHandlerParameterClass(mixed $handler): ?string
    {
        $reflectionMethod     = new ReflectionMethod($handler[0], $handler[1]);
        $reflectionParameters = $reflectionMethod->getParameters();

        return empty($reflectionParameters)
            ? null
            : $reflectionParameters[0]->getType()->getName();
    }

    public function registerGetRoute(
        string|array   $urls,
        callable|array $callback
    ): void
    {
        $this->registerRoute("GET", $urls, $callback);
    }

    public function registerPostRoute(
        string|array   $urls,
        callable|array $callback
    ): void
    {
        $this->registerRoute("POST", $urls, $callback);
    }

    public function registerRoute(
        string         $httpMethod,
        string|array   $urls,
        callable|array $callback
    ): void
    {
        if (is_array($urls)) {
            foreach ($urls as $url) {
                $this->routes[$url][$httpMethod] = $callback;
            }

            return;
        }

        $this->routes[$urls][$httpMethod] = $callback;
    }

    #[NoReturn] private function clientError(): void
    {
        header("Location: /404");
        die;
    }

    #[NoReturn] private function serverError(): void
    {
        header("Location: /502");
        die;
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    private function provideInstance(string $class): mixed
    {
        $reflectionClass = new ReflectionClass($class);
        $constructor = $reflectionClass->getConstructor();

        if ($constructor !== null) {
            $args = [];

            foreach ($_POST as $key => $value) {
                $args[$key] = $value;
            }

            $args = [$args];

            return $reflectionClass->newInstanceArgs($args);
        }

        return $reflectionClass->newInstance();
    }
}