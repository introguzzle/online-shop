<?php

use request\Request;

class Application {
    private array $routes = [];

    public function run(): void {
        $requestUri = $_SERVER["REQUEST_URI"];
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if (!array_key_exists($requestUri, $this->routes)) {
            header("HTTP/1.0 404 Not Found", true, 404);
            echo $this->noSuchRoute($requestUri);
            require_once "./../view/404.html";
            return;
        }

        $route = $this->routes[$requestUri][$requestMethod];

        if (!isset($route)) {
            echo $this->noSuchMethod($requestUri, $requestMethod);
            require_once "./../view/404.html";
            return;
        }

        $class       = $route["class"];
        $classMethod = $route["method"];

        if (!class_exists($class)) {
            echo $this->noSuchClass($class);
            require_once "./../view/404.html";
            return;
        }

        $instance = new $class();

        if (!method_exists($instance, $classMethod)) {
            echo $this->noSuchClassMethod($instance, $classMethod);
            require_once "./../view/404.html";
            return;
        }

        $instance->$classMethod();
    }

    public function registerGetRoute(string $url,
                                     string $class,
                                     string $classMethod): void {
        $this->routes[$url]["GET"] = [
            "class"   => $class,
            "method"  => $classMethod,
        ];
    }

    public function registerPostRoute(string $url,
                                      string $class,
                                      string $classMethod): void {
        $this->routes[$url]["POST"] = [
            "class"   => $class,
            "method"  => $classMethod,
        ];
    }

    private function noSuchMethod(mixed $requestUri,
                                  mixed $requestMethod): string {
        return "$requestUri doesn't support $requestMethod method";
    }

    private function noSuchClass(mixed $class): string {
        return "$class is not present";
    }

    private function noSuchClassMethod(mixed $classMethod,
                                       mixed $class): string {
        return "No such requested $classMethod in class $class";
    }

    private function noSuchRoute(mixed $requestUri): string {
        return "No such requested $requestUri";
    }
}