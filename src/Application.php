<?php

class Application
{
    private array $routes = [];
    private Logger $logger;

    public function __construct() {
        $this->logger = new Logger();
    }

    public function run(): void
    {
        $requestUri = $_SERVER["REQUEST_URI"];

        if (!array_key_exists($requestUri, $this->routes)) {
            $this->clientError();
            return;
        }

        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if (!isset($this->routes[$requestUri][$requestMethod])) {
            $this->clientError();
            return;
        }

        $handler = $this->routes[$requestUri][$requestMethod];

        if (is_array($handler)) {
            $handler[0] = new $handler[0];
        }

        try {
            $handler();
        } catch (Throwable $t) {
            $this->logger->error($t);
            $this->serverError();
            return;
        }
    }

    public function registerGetRoute(
        string | array $urls,
        callable | array $callback
    ): void
    {
        $this->registerRoute("GET", $urls, $callback);
    }

    public function registerPostRoute(
        string | array $urls,
        callable | array $callback
    ): void
    {
        $this->registerRoute("POST", $urls, $callback);
    }

    public function registerRoute(
        string $httpMethod,
        string | array $urls,
        callable | array $callback
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

    private function clientError(): void
    {
        header("Location: /404");
    }

    private function serverError(): void
    {
        header("Location: /502");
    }
}