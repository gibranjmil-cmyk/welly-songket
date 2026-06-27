<?php

declare(strict_types=1);

namespace WellySongket\Models;

use WellySongket\Core\Database;

final class ProductMedia
{
    public static function forProduct(int $productId): array
    {
        return Database::query(
            'SELECT * FROM product_media WHERE product_id = ? ORDER BY is_cover DESC, sort_order ASC',
            [$productId]
        );
    }

    public static function create(int $productId, string $fileName, string $mediaType, bool $isCover = false): int
    {
        return Database::insert(
            'INSERT INTO product_media (product_id, file_name, media_type, is_cover) VALUES (?, ?, ?, ?)',
            [$productId, $fileName, $mediaType, $isCover ? 1 : 0]
        );
    }

    public static function delete(int $id): ?array
    {
        $row = Database::queryOne('SELECT * FROM product_media WHERE id = ?', [$id]);
        if ($row) {
            Database::execute('DELETE FROM product_media WHERE id = ?', [$id]);
        }
        return $row;
    }

    public static function setCover(int $productId, int $mediaId): void
    {
        Database::execute('UPDATE product_media SET is_cover = 0 WHERE product_id = ?', [$productId]);
        Database::execute('UPDATE product_media SET is_cover = 1 WHERE id = ?', [$mediaId]);
    }
}
