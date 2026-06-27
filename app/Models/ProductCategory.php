<?php

declare(strict_types=1);

namespace WellySongket\Models;

use WellySongket\Core\Database;

final class ProductCategory
{
    public static function all(): array
    {
        return Database::query(
            "SELECT * FROM product_categories WHERE status = 'aktif' ORDER BY id ASC"
        );
    }

    public static function find(int $id): ?array
    {
        return Database::queryOne(
            'SELECT * FROM product_categories WHERE id = ? LIMIT 1',
            [$id]
        );
    }

    public static function create(string $name): int
    {
        return Database::insert(
            "INSERT INTO product_categories (name, status) VALUES (?, 'aktif')",
            [$name]
        );
    }

    public static function toggle(int $id, string $status): void
    {
        Database::execute(
            'UPDATE product_categories SET status = ? WHERE id = ?',
            [$status, $id]
        );
    }

    public static function delete(int $id): void
    {
        Database::execute('DELETE FROM product_categories WHERE id = ?', [$id]);
    }
}
