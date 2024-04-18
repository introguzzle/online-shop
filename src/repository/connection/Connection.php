<?php

namespace repository\connection;

interface Connection
{
    public function prepare(string $query, array $options = []): Statement|false;

    public function startTransaction(): bool;

    public function rollback(): bool;

    public function commit(): bool;

    public function inTransaction(): bool;
}