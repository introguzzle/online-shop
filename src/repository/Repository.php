<?php

namespace repository;

use entity\Entity;
use InvalidArgumentException;
use repository\connection\Connection;
use repository\connection\ConnectionException;
use repository\hydrator\Hydrator;
use PDO;

abstract class Repository
{
    protected Connection $connection;

    protected Hydrator $hydrator;

    public const string JOIN_AND = "AND";
    public const string JOIN_OR  = "OR";

    public const string ASCENDING = "ASC";
    public const string DESCENDING = "DESC";

    public function __construct(
        Connection $connection,
        Hydrator   $hydrator
    )
    {
        $this->connection = $connection;
        $this->hydrator = $hydrator;
    }

    public abstract function getTableName(): string;
    public abstract function getEntityClass(): string;

    public function getAll(): ?array
    {
        $table = $this->getTableName();

        $query = "SELECT * FROM $table";
        $fetched = $this->connection->prepare($query)->executeThenFetchAll();

        return $this->hydrateAll($fetched);
    }

    public function getByColumn(
        string $column,
        mixed $value,
        bool $unique = false,
        string $join = self::JOIN_AND,
        ?array $orderBy = null
    ): Entity | array | null
    {
        return $this->getByCriteria([$column => $value], $unique, $join, $orderBy);
    }

    public function getByCriteria(
        array $criteria,
        bool $unique = false,
        string $join = self::JOIN_AND,
        ?array $orderBy = null
    ): Entity | array | null
    {
        $table = $this->getTableName();
        $conditions = [];

        foreach ($criteria as $column => $value) {
            $conditions[] = "$column = :$column";
        }

        $orderByClause = "";

        if ($orderBy) {
            $orderByColumn    = key($orderBy);
            $orderByDirection = current($orderBy);
            $orderByClause    = "ORDER BY $orderByColumn $orderByDirection";
        }

        $where = implode(" " . $join . " ", $conditions);
        $query = "SELECT * FROM $table WHERE $where $orderByClause";

        $stmt = $this->connection->prepare($query);

        foreach ($criteria as $column => $value) {
            $stmt->bindValue(":$column", $value);
        }

        $data = $stmt->executeThenFetchAll();

        if (empty($data)) {
            return $unique ? null : [];
        }

        return $unique ? $this->hydrate($data[0]) : $this->hydrateAll($data);
    }

    public function deleteById(mixed $id): void
    {
        $table = $this->getTableName();

        $query = "DELETE FROM $table WHERE id = :id";
        $stmt = $this->connection->prepare($query);

        $stmt->bindValue(":id", $id);
        $stmt->execute();
    }

    public function getById(mixed $id): ?Entity
    {
        $entity = $this->getByColumn("id", $id);
        return empty($entity) ? null : $entity[0];
    }

    public function save(Entity $entity): Entity
    {
        $table = $this->getTableName();
        $entityData = $this->hydrator->extract($entity);

        unset($entityData["id"]);

        $columns = array_keys($entityData);

        $placeholders = implode(', ', array_map(fn($column) => ":$column", $columns));
        $columnNames = implode(', ', $columns);

        $query = "INSERT INTO $table ($columnNames) VALUES ($placeholders) RETURNING id";
        $stmt = $this->connection->prepare($query);

        foreach ($entityData as $column => $value) {
            $stmt->bindValue(":$column", $value, $this->acquireType($value));
        }

        $data = $stmt->executeThenFetch();

        if (!isset($data["id"])) {
            throw new ConnectionException();
        }

        $entity->setId($data["id"]);
        return $entity;
    }

    private function acquireType(mixed $value): int
    {
        $type = gettype($value);

        return match ($type) {
            'boolean' => PDO::PARAM_BOOL,
            'integer' => PDO::PARAM_INT,
            'double', 'string', 'NULL' => PDO::PARAM_STR,
            default => throw new InvalidArgumentException("Unsupported data type: " . $type),
        };
    }

    public function hydrate(array $data): Entity
    {
        return $this->hydrator->hydrate($this->getEntityClass(), $data);
    }

    public function hydrateAll(array $data): array
    {
        $entities = [];

        if (empty($data)) {
            return [];
        }

        foreach ($data as $item) {
            $entities[] = $this->hydrate($item);
        }

        return $entities;
    }

    public function updateColumnById(
        string $column,
        int $id,
        string $value
    ): bool
    {
        $table = $this->getTableName();
        $query = "UPDATE $table SET $column=:value WHERE id=:id";

        $stmt = $this->connection->prepare($query);

        $stmt->bindValue(":value", $value);
        $stmt->bindValue(":id", $id);

        $stmt->execute();
        return true;
    }
}
