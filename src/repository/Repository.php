<?php

namespace repository;

use dto\DTO;

interface Repository {
    function save(DTO $dto): ?DTO;
    function saveAll(array $array): ?array;
    function getById(int|string $id): ?object;
    function getAll(): ?array;
}
