<?php

namespace repository;

use PDO;

final class PDOHolder {
    private static PDO $pdo;

    public static function getPdo(): PDO {
        if (!isset(self::$pdo)) {
            $host = getenv("POSTGRES_DB");
            $user = getenv("POSTGRES_USER");
            $pass = getenv("POSTGRES_PASSWORD");
            $port = getenv("POSTGRES_PORT");
            $conn = getenv("POSTGRES_CONNECTION");

            $dsn = sprintf("%s:host=postgres; port=%s; dbname=%s", $conn, $port, $host);

            self::$pdo = new PDO($dsn, $user, $pass);
        }

        return self::$pdo;
    }
}
