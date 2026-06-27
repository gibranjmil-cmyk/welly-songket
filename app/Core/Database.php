<?php

declare(strict_types=1);

namespace WellySongket\Core;

use PDO;
use PDOException;
use RuntimeException;

final class Database
{
    private static ?PDO $instance = null;

    public static function connect(): PDO
    {
        if (self::$instance !== null) {
            return self::$instance;
        }

        $host     = (string) env('DB_HOST', 'localhost');
        $port     = (int)   env('DB_PORT', 3306);
        $dbname   = (string) env('DB_DATABASE', 'welly_songket');
        $username = (string) env('DB_USERNAME', 'root');
        $password = (string) env('DB_PASSWORD', '');

        $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";

        try {
            self::$instance = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            throw new RuntimeException('Database connection failed: ' . $e->getMessage());
        }

        return self::$instance;
    }

    public static function pdo(): PDO
    {
        return self::connect();
    }

    /** Run a SELECT and return all rows. */
    public static function query(string $sql, array $bindings = []): array
    {
        $stmt = self::pdo()->prepare($sql);
        $stmt->execute($bindings);
        return $stmt->fetchAll();
    }

    /** Run a SELECT and return the first row or null. */
    public static function queryOne(string $sql, array $bindings = []): ?array
    {
        $stmt = self::pdo()->prepare($sql);
        $stmt->execute($bindings);
        $row = $stmt->fetch();
        return $row === false ? null : $row;
    }

    /** Run INSERT / UPDATE / DELETE and return affected row count. */
    public static function execute(string $sql, array $bindings = []): int
    {
        $stmt = self::pdo()->prepare($sql);
        $stmt->execute($bindings);
        return $stmt->rowCount();
    }

    /** Run INSERT and return the last inserted ID. */
    public static function insert(string $sql, array $bindings = []): int
    {
        self::execute($sql, $bindings);
        return (int) self::pdo()->lastInsertId();
    }
}
