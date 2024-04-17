<?php

namespace request;

class Request {
    private string $method;
    private string $uri;
    private array $headers;
    private array $body;

    public function __construct(string $method,
                                string $uri,
                                array $headers,
                                array $body = []) {
        $this->method = $method;
        $this->uri = $uri;
        $this->headers = $headers;
        $this->body = $body;
    }

    public function getMethod(): string {
        return $this->method;
    }

    public function getUri(): string {
        return $this->uri;
    }

    public function getHeaders(): array {
        return $this->headers;
    }

    public function getBody(): array {
        return $this->body;
    }

    public function appendBody(string $key, mixed $value): void
    {
        $this->body[$key] = $value;
    }
}