<?php

namespace repository;

interface Repository {
    function save(object $object): ?object;
    function saveAll(array $array): ?array;
    function getById(mixed $id): ?object;
    function getAll(): ?array;
}
