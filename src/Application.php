<?php

class Application {
    private array $routes = [];

    public function register(): void {
        $files = scandir(__DIR__ . "/src");

        $phpFiles = array_filter($files, function($file) {
            return pathinfo($file, PATHINFO_EXTENSION) === 'php';
        });
    }

    public function r(): void {
        $requestUri = $_SERVER["REQUEST_URI"];
        $requestMethod = $_SERVER["REQUEST_METHOD"];
    }

    public function run(): void {
        $requestUri = $_SERVER["REQUEST_URI"];
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if (!array_key_exists($requestUri, $this->routes)) {
            $this->error();
            return;
        }

        $route = $this->routes[$requestUri][$requestMethod];

        if (!isset($route)) {
            $this->error();
            return;
        }

        $class          = $route["class"];
        $instanceMethod = $route["method"];

        if (!class_exists($class)) {
            $this->error();
            return;
        }

        $instance = new $class();

        if (!method_exists($instance, $instanceMethod)) {
            $this->error();
            return;
        }

        $instance->$instanceMethod();
    }

    public function registerGetRoute(string $url,
                                     string $class,
                                     string $instanceMethod): void {
        $this->registerRoute("GET", $url, $class, $instanceMethod);
    }

    public function registerPostRoute(string $url,
                                      string $class,
                                      string $instanceMethod): void {
        $this->registerRoute("POST", $url, $class, $instanceMethod);
    }

    public function registerRoute(string $httpMethod,
                                  string | array $urls,
                                  string $class,
                                  string $instanceMethod): void {
        if (gettype($urls) == "string") {
            $this->routes[$urls][$httpMethod] = [
                "class"   => $class,
                "method"  => $instanceMethod,
            ];
        } else {
            foreach ($urls as $url) {
                $this->routes[$url][$httpMethod] = [
                    "class"   => $class,
                    "method"  => $instanceMethod,
                ];
            }
        }
    }

    private function error(): void {
        header("Location: /404");
    }
}