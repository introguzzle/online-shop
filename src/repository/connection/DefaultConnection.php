<?php

namespace repository\connection;

use PDO;
use repository\PDOHolder;

class DefaultConnection implements Connection
{
    private PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        if ($pdo === null) {
            $this->pdo = PDOHolder::getPdo();
        } else {
            $this->pdo = $pdo;
        }
    }

    public function prepare(string $query, array $options = []): Statement|false
    {
        return new Statement($this->pdo->prepare($query, $options));
    }

    public function startTransaction(): bool
    {
        return $this->pdo->beginTransaction();
    }

    public function rollback(): bool
    {
        return $this->pdo->rollBack();
    }

    public function commit(): bool
    {
        return $this->pdo->commit();
    }

    public function inTransaction(): bool
    {
        return $this->pdo->inTransaction();
    }
}