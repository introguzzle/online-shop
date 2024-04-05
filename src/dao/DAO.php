<?php

namespace dao;

use PDO;

final class DAO {
    public static PDO $pdo;

    public static function getPdo(): PDO {
        if (!isset($pdo))
            $pdo = new PDO(
                "pgsql:host=postgres; port=5432; dbname=db",
                "dbuser",
                "dbpwd"
            );

        return $pdo;
    }
}