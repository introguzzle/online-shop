<?php

namespace repository;

use dto\DTO;
use Logger;
use PDO;
use PDOStatement;
use ReflectionClass;
use Throwable;
use utils\DTOUtils;

abstract class Repository
{
    protected Logger $logger;
    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = PDOHolder::getPdo();
        $this->logger = new Logger();
    }

    public abstract function getTableName(): string;

    public function getAll(string $dtoClass): ?array
    {
        $table = $this->getTableName();
        $query = "SELECT * FROM $table";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        $fetched = $stmt->fetchAll();

        try {
            return $this->allFetchedToDTO($dtoClass, $fetched);
        } catch (Throwable $t) {
            $this->logger->error($t);
            return null;
        }
    }

    protected function getByColumn(
        string $dtoClass,
        string $column,
        mixed $value
    ): ?DTO
    {
        $table = $this->getTableName();

        $query = "SELECT * FROM $table WHERE $column=:$column";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":$column", $value);
        $stmt->execute();

        $fetched = $stmt->fetch();

        try {
            return $this->fetchToDTO($dtoClass, $fetched);
        } catch (Throwable $t) {
            $this->logger->error($t);
            return null;
        }
    }

    public function getColumns(): array
    {
        $table = $this->getTableName();

        $query = "SELECT column_name
                FROM information_schema.columns
                WHERE table_name = :table_name";

        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(":table_name", $table);

        try {
            $stmt->execute();
            $array = $stmt->fetchAll();
            return self::saveFlatMap($array);
        } catch (Throwable $t) {
            $this->logger->error($t);
            return [];
        }
    }

    public function save(DTO $dto): ?DTO {
        $table = $this->getTableName();
        $columns = $this->getColumns();

        foreach ($columns as $k => $v) {
            if ($v == "id") {
                unset($columns[$k]);
                break;
            }
        }

        $placeholders = implode(', ', array_map(fn($column) => ":$column", $columns));

        $columnNames = implode(', ', $columns);

        $query = "INSERT INTO $table ($columnNames) VALUES ($placeholders)";

        $this->logger->info($query);

        try {
            $stmt = $this->pdo->prepare($query);

            foreach ($columns as $column) {
                $getter = DTOUtils::getGetterByField($column);
                $value = $dto->$getter();

                $stmt->bindValue(":$column", $value);
            }

            $stmt->execute();

            return $dto;
        } catch (Throwable $t) {
            $this->logger->error($t);
            return null;
        }
    }

    private function saveFlatMap(array $array): array {
        $flat = [];

        foreach ($array as $item) {
            $flat[] = $item[0];
        }

        return $flat;
    }

    public function fetchToDTO(
        string $dtoClass,
        mixed $fetched
    ): ?DTO
    {
        if (is_array($fetched)) {
            $columns = $this->getColumns();

            $reflectionClass = new ReflectionClass($dtoClass);

            if ($reflectionClass->hasMethod('__construct')) {
                $constructor = $reflectionClass->getMethod('__construct');
                $parameters = $constructor->getParameters();

                $values = [];
                foreach ($parameters as $parameter) {
                    $snake = DTOUtils::camelToSnake($parameter->getName());

                    if (in_array($snake, $columns))
                        $values[] = $fetched[$snake];
                }

                return $reflectionClass->newInstanceArgs($values);
            }
        }

        return null;
    }

    public function allFetchedToDTO(
        string $dtoClass,
        array $allFetched
    ): array
    {
        $dtos = [];
        foreach ($allFetched as $singleFetch)
            $dtos[] = $this->fetchToDTO($dtoClass, $singleFetch);

        return $dtos;
    }

    public function updateColumnById(
        string $column,
        int $id,
        string $value
    ): bool
    {
        $table = $this->getTableName();
        $query = "UPDATE $table SET $column=:value WHERE id=:id";

        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(":value", $value);
        $stmt->bindParam(":id", $id);

        try {
            $stmt->execute();
            return true;
        } catch (Throwable $t) {
            $this->logger->error($t);
            return false;
        }
    }
}
