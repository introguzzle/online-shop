<?php

namespace repository\hydrator;

use entity\Entity;

interface Hydrator
{
    public function hydrate(string $entityClass, array $data): Entity;
    public function extract(Entity $entity): array;
}