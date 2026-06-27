<?php

declare(strict_types=1);

namespace WellySongket\Models;

use WellySongket\Core\Database;

final class Admin
{
    public static function findByUsername(string $username): ?array
    {
        return Database::queryOne(
            'SELECT * FROM admins WHERE username = ? LIMIT 1',
            [$username]
        );
    }

    public static function verifyPassword(string $plain, string $hash): bool
    {
        // Support bcrypt hash stored in DB
        if (str_starts_with(trim($hash), '$2y$') || str_starts_with(trim($hash), '$2b$')) {
            return password_verify($plain, trim($hash));
        }
        // Plain-text fallback (timing-safe)
        return hash_equals(trim($hash), $plain);
    }
}
