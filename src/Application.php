<?php

class Application {
    private array $routes = [];

    public function run(): void
    {
        $requestUri = $_SERVER["REQUEST_URI"];

        if (!array_key_exists($requestUri, $this->routes)) {
            $this->error();
            return;
        }

        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if (!isset($this->routes[$requestUri][$requestMethod])) {
            $this->error();
            return;
        }

        $route = $this->routes[$requestUri][$requestMethod];

        if (!isset($route)) {
            $this->error();
            return;
        }

        if (is_array($route)) {
            $instance       = $route["instance"];
            $instanceMethod = $route["method"];

            $instance->$instanceMethod();

        } else {
            $route();
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
        if (is_array($callback)) {
            $callback = [
                "instance" => new $callback[0](),
                "method"   => $callback[1]
            ];
        }

        if (is_array($urls)) {
            foreach ($urls as $url)
                $this->routes[$url][$httpMethod] = $callback;
        } else {
            $this->routes[$urls][$httpMethod] = $callback;
        }
    }

    private function error(): void
    {
        header("Location: /404");
    }
}