<?php

namespace repository;

use entity\Order;
use repository\hydrator\Hydrator;

class OrderRepository extends Repository
{
    public function __construct(Hydrator $hydrator)
    {
        parent::__construct($hydrator);
    }

    public function getTableName(): string
    {
        return "orders";
    }

    public function getEntityClass(): string
    {
        return Order::class;
    }
}