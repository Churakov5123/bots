<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Profile\Enum;

enum Platform: int
{
    case Telegram = 1;
    public static function getProperties(): array
    {
        $data = [];

        foreach (self::cases() as $item) {
            $data[] = $item->value;
        }

        return $data;
    }
}
