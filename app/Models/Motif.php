<?php

declare(strict_types=1);

namespace WellySongket\Models;

use WellySongket\Core\Database;

final class Motif
{
    public static function all(): array
    {
        return Database::query(
            'SELECT m.*, mc.name AS category_name
             FROM motifs m
             LEFT JOIN motif_categories mc ON mc.id = m.category_id
             ORDER BY m.id ASC'
        );
    }

    public static function find(int $id): ?array
    {
        return Database::queryOne(
            'SELECT m.*, mc.name AS category_name
             FROM motifs m
             LEFT JOIN motif_categories mc ON mc.id = m.category_id
             WHERE m.id = ? LIMIT 1',
            [$id]
        );
    }

    public static function create(array $data): int
    {
        return Database::insert(
            'INSERT INTO motifs (name, keywords, category_id, philosophy, description, reference_image)
             VALUES (?, ?, ?, ?, ?, ?)',
            [
                $data['name'],
                $data['keywords'] ?? null,
                $data['category_id'] ?: null,
                $data['philosophy'] ?? null,
                $data['description'] ?? null,
                $data['reference_image'] ?? null,
            ]
        );
    }

    public static function update(int $id, array $data): void
    {
        Database::execute(
            'UPDATE motifs SET name = ?, keywords = ?, category_id = ?, philosophy = ?, description = ? WHERE id = ?',
            [
                $data['name'],
                $data['keywords'] ?? null,
                $data['category_id'] ?: null,
                $data['philosophy'] ?? null,
                $data['description'] ?? null,
                $id,
            ]
        );
    }

    public static function delete(int $id): void
    {
        Database::execute('DELETE FROM motifs WHERE id = ?', [$id]);
    }
}
