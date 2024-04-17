<?php

namespace repository;

use entity\Entity;
use InvalidArgumentException;
use repository\hydrator\Hydrator;
use PDO;

abstract class Repository
{
    protected PDO $pdo;

    protected Hydrator $hydrator;

    public const string JOIN_AND = "AND";
    public const string JOIN_OR  = "OR";

    public function __construct(
        Hydrator $hydrator
    )
    {
        $this->pdo = PDOHolder::getPdo();
        $this->hydrator = $hydrator;
    }

    public abstract function getTableName(): string;
    public abstract function getEntityClass(): string;

    public function getAll(): ?array
    {
        $table = $this->getTableName();

        $query = "SELECT * FROM $table";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        $fetched = $stmt->fetchAll();

        return $this->hydrateAll($fetched);
    }

    public function getByColumn(
        string $column,
        mixed $value,
        bool $unique = false,
    ): Entity | array | null
    {
        return $this->getByCriteria([$column => $value], $unique);
    }

    public function getByCriteria(
        array $criteria,
        bool $unique = false,
        string $join = self::JOIN_AND
    ): Entity | array | null
    {
        $table = $this->getTableName();
        $conditions = [];

        foreach ($criteria as $column => $value) {
            $conditions[] = "$column = :$column";
        }

        $where = implode(" " . $join . " ", $conditions);
        $query = "SELECT * FROM $table WHERE $where";

        $stmt = $this->pdo->prepare($query);

        foreach ($criteria as $column => $value) {
            $stmt->bindValue(":$column", $value);
        }

        $stmt->execute();
        $data = $stmt->fetchAll();

        if (empty($data)) {
            return $unique ? null : [];
        }

        return $unique ? $this->hydrate($data[0]) : $this->hydrateAll($data);
    }

    public function deleteById(mixed $id): void
    {
        $table = $this->getTableName();

        $query = "DELETE FROM $table WHERE id = :id";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindValue(":id", $id);
        $stmt->execute();
    }

    public function getById(mixed $id): ?Entity
    {
        return $this->getByColumn("id", $id)[0];
    }

    public function save(Entity $entity): ?Entity
    {
        $table = $this->getTableName();
        $entityData = $this->hydrator->extract($entity);

        // When saved, no need to save id since it will be auto-incremented anyway
        unset($entityData["id"]);

        $columns = array_keys($entityData);

        $placeholders = implode(', ', array_map(fn($column) => ":$column", $columns));
        $columnNames = implode(', ', $columns);

        $query = "INSERT INTO $table ($columnNames) VALUES ($placeholders) RETURNING id";
        $stmt = $this->pdo->prepare($query);

        foreach ($entityData as $column => $value) {
            $stmt->bindValue(":$column", $value, $this->acquireType($value));
        }

        $stmt->execute();
        $id = ($stmt->fetch())["id"];

        $entity->setId($id);

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

        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(":value", $value);
        $stmt->bindParam(":id", $id);

        $stmt->execute();
        return true;
    }

    public function beginTransaction(): bool
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
}
