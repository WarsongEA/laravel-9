<?php

namespace App\Utilities;

use App\Utilities\Contracts\RedisHelperInterface;
use Illuminate\Support\Facades\Cache;

final class RedisHelper implements RedisHelperInterface
{
    private const CACHE_NAME = 'email:cached:id:';

    public function storeRecentMessage(mixed $id, string $messageSubject, string $toEmailAddress): void
    {
        $value = [
            'subject' => $messageSubject,
            'email' => $toEmailAddress
        ];
        $id = (string) $id;

        Cache::put(key: self::CACHE_NAME . $id, value: $value);
    }
}
