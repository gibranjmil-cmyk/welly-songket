<?php

declare(strict_types=1);

namespace WellySongket\Models;

use WellySongket\Core\Database;

final class Product
{
    public static function all(): array
    {
        return Database::query(
            "SELECT p.*, pc.name AS category_name
             FROM products p
             LEFT JOIN product_categories pc ON pc.id = p.category_id
             WHERE p.status = 'aktif'
             ORDER BY p.id ASC"
        );
    }

    public static function allWithMedia(): array
    {
        $products = self::all();
        foreach ($products as &$product) {
            $product['media'] = ProductMedia::forProduct((int) $product['id']);
            $product['motifs'] = Database::query(
                'SELECT m.* FROM motifs m
                 JOIN product_motifs pm ON pm.motif_id = m.id
                 WHERE pm.product_id = ?',
                [(int) $product['id']]
            );
        }
        return $products;
    }

    public static function find(int $id): ?array
    {
        return Database::queryOne(
            "SELECT p.*, pc.name AS category_name
             FROM products p
             LEFT JOIN product_categories pc ON pc.id = p.category_id
             WHERE p.id = ? LIMIT 1",
            [$id]
        );
    }

    public static function create(array $data): int
    {
        return Database::insert(
            "INSERT INTO products (name, category_id, category, description, status)
             VALUES (?, ?, ?, ?, 'aktif')",
            [
                $data['name'],
                $data['category_id'] ?: null,
                $data['category'] ?? null,
                $data['description'] ?? null,
            ]
        );
    }

    public static function update(int $id, array $data): void
    {
        Database::execute(
            'UPDATE products SET name = ?, category_id = ?, description = ? WHERE id = ?',
            [$data['name'], $data['category_id'] ?: null, $data['description'] ?? null, $id]
        );
    }

    public static function delete(int $id): void
    {
        Database::execute('DELETE FROM products WHERE id = ?', [$id]);
    }

    public static function toggle(int $id, string $status): void
    {
        Database::execute(
            'UPDATE products SET status = ? WHERE id = ?',
            [$status, $id]
        );
    }
}
