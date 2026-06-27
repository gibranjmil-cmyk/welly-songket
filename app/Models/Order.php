<?php

declare(strict_types=1);

namespace WellySongket\Models;

use WellySongket\Core\Database;

final class Order
{
    public static function all(): array
    {
        return Database::query(
            "SELECT o.*, p.name AS product_name
             FROM orders o
             LEFT JOIN products p ON p.id = o.product_id
             ORDER BY o.created_at DESC"
        );
    }

    public static function find(int $id): ?array
    {
        $order = Database::queryOne(
            'SELECT o.*, p.name AS product_name FROM orders o
             LEFT JOIN products p ON p.id = o.product_id
             WHERE o.id = ? LIMIT 1',
            [$id]
        );
        if ($order) {
            $order['sizes'] = Database::queryOne(
                'SELECT * FROM order_sizes WHERE order_id = ? LIMIT 1',
                [$id]
            );
        }
        return $order;
    }

    public static function create(array $data): int
    {
        return Database::insert(
            "INSERT INTO orders (customer_name, phone, address, product_id, notes, status)
             VALUES (?, ?, ?, ?, ?, 'Pending')",
            [
                $data['customer_name'],
                $data['phone'],
                $data['address'],
                $data['product_id'] ?: null,
                $data['notes'] ?? null,
            ]
        );
    }

    public static function updateStatus(int $id, string $status): void
    {
        $allowed = ['Pending', 'Diproses', 'Selesai', 'Dikirim'];
        if (!in_array($status, $allowed, true)) return;
        Database::execute('UPDATE orders SET status = ? WHERE id = ?', [$status, $id]);
    }

    public static function delete(int $id): void
    {
        Database::execute('DELETE FROM orders WHERE id = ?', [$id]);
    }

    public static function countByStatus(): array
    {
        $rows = Database::query(
            "SELECT status, COUNT(*) AS total FROM orders GROUP BY status"
        );
        $map = [];
        foreach ($rows as $row) {
            $map[$row['status']] = (int) $row['total'];
        }
        return $map;
    }
}
