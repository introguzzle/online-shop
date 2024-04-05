<?php

namespace request;


class RequestBuilder {
    private string $method;
    private string $uri;
    private array $headers;
    private array $body;

    public function method(string $method): RequestBuilder {
        $this->method = $method;
        return $this;
    }

    public function uri(string $uri): RequestBuilder {
        $this->uri = $uri;
        return $this;
    }

    public function headers(array $headers): RequestBuilder {
        $this->headers = $headers;
        return $this;
    }

    public function body(array $body): RequestBuilder {
        $this->body = $body;
        return $this;
    }

    public function build(): Request {
        return new Request($this->method, $this->uri, $this->headers, $this->body);
    }
}