<?php

namespace repository;

use entity\Order;
use repository\connection\Connection;
use repository\hydrator\Hydrator;

class OrderRepository extends Repository
{
    public function __construct(
        Connection $connection,
        Hydrator $hydrator
    )
    {
        parent::__construct($connection, $hydrator);
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