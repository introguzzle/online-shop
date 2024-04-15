<?php

namespace repository;

use entity\Entity;
use Logger;
use repository\hydrator\DefaultHydrator;
use repository\hydrator\Hydrator;
use PDO;

abstract class Repository
{
    protected Logger $logger;
    protected PDO $pdo;

    protected Hydrator $hydrator;

    public const string JOIN_AND = "AND";
    public const string JOIN_OR  = "OR";

    public function __construct()
    {
        $this->pdo = PDOHolder::getPdo();
        $this->logger = new Logger();
        $this->hydrator = new DefaultHydrator();
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
        mixed $value
    ): ?Entity
    {
        return $this->getByCriteria([$column => $value]);
    }

    public function getByCriteria(
        array $criteria,
        string $join = self::JOIN_AND
    ): ?Entity
    {
        $table = $this->getTableName();
        $conditions = [];

        foreach ($criteria as $column => $value) {
            $conditions[] = "$column = :$column";
        }

        $where = implode($join, $conditions);
        $query = "SELECT * FROM $table WHERE $where";

        $stmt = $this->pdo->prepare($query);

        foreach ($criteria as $column => $value) {
            $stmt->bindValue(":$column", $value);
        }

        $stmt->execute();
        $data = $stmt->fetch();

        if (empty($data)) {
            return null;
        }

        return $this->hydrate($data);
    }

    public function getById(mixed $id): ?Entity
    {
        return $this->getByColumn("id", $id);
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

        $query = "INSERT INTO $table ($columnNames) VALUES ($placeholders)";

        $this->logger->info($query);

        $stmt = $this->pdo->prepare($query);

        foreach ($entityData as $column => $value) {
            $stmt->bindValue(":$column", $value);
        }

        $stmt->execute();

        return $entity;
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
}
