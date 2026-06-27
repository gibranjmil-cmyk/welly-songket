<?php

declare(strict_types=1);

namespace WellySongket\Models;

use WellySongket\Core\Database;

final class OrderSize
{
    public static function create(int $orderId, array $data): int
    {
        return Database::insert(
            'INSERT INTO order_sizes
             (order_id, tinggi_badan, berat_badan, lebar_bahu, lebar_dada, panjang_lengan, panjang_badan, panjang_kaki)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $orderId,
                $data['tinggi_badan']   ?? null,
                $data['berat_badan']    ?? null,
                $data['lebar_bahu']     ?? null,
                $data['lebar_dada']     ?? null,
                $data['panjang_lengan'] ?? null,
                $data['panjang_badan']  ?? null,
                $data['panjang_kaki']   ?? null,
            ]
        );
    }
}
