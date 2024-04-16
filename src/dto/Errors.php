<?php

namespace dto;

class Errors extends DTO
{
    private array $errors;
    private bool $hasErrors;

    private function __construct()
    {
        $this->errors = [];
        $this->hasErrors = false;
    }

    public static function create(): static
    {
        return new Errors();
    }

    public function add(
        string $key,
        string $message = "Unknown error"
    ): void
    {
        $this->errors[$key] = $message;
        $this->hasErrors = true;
    }

    public function hasAny(): bool
    {
        return $this->hasErrors || !empty($errors);
    }

    public function hasNone(): bool
    {
        return !$this->hasAny();
    }

    public function hasKey(string $key): bool
    {
        return array_key_exists($key, $this->errors);
    }

    public function getMessage(string $key): string
    {
        return $this->errors[$key];
    }

    public function getAllMessages(): array
    {
        return array_values($this->errors);
    }

    public function getAllKeys(): array
    {
        return array_keys($this->errors);
    }
}