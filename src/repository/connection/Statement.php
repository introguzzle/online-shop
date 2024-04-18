<?php

namespace repository\connection;

use PDO;
use PDOStatement;

class Statement
{
    public PDOStatement $statement;

    public function __construct(PDOStatement $statement)
    {
        $this->statement = $statement;
    }

    public function execute(array $params = null): static
    {
        $this->statement->execute($params);
        return $this;
    }

    public function executeThenFetch(
        array $params = null,
        $mode = PDO::FETCH_BOTH,
        $cursorOrientation = PDO::FETCH_ORI_NEXT,
        $cursorOffset = 0
    ): array
    {
        return $this->execute($params)->fetch($mode, $cursorOrientation, $cursorOffset);
    }

    public function executeThenFetchAll(
        array $params = null,
        int $mode = PDO::FETCH_BOTH,
    ): array
    {
        return $this->execute($params)->fetchAll($mode);
    }

    public function fetchAll(
        int $mode = PDO::FETCH_BOTH,
    ): array
    {
        $fetched = $this->statement->fetchAll($mode);
        return $fetched === false ? [] : $fetched;
    }

    public function fetch(
        int $mode = PDO::FETCH_BOTH,
        int $cursorOrientation = PDO::FETCH_ORI_NEXT,
        int $cursorOffset = 0
    ): array
    {
        $fetched = $this->statement->fetch($mode, $cursorOrientation, $cursorOffset);
        return $fetched === false ? [] : $fetched;
    }

    public function bindValue(
        mixed $param,
        mixed $value,
        int $type = PDO::PARAM_STR
    ): bool
    {
        return $this->statement->bindValue($param, $value, $type);
    }

    public function bindParam(
        mixed $param,
        mixed &$value,
        int $type = PDO::PARAM_STR,
        ?int $maxLength = null,
        mixed $driverOptions = null
    ): bool
    {
        return $this->statement->bindParam($param, $value, $type, $maxLength, $driverOptions);
    }
}