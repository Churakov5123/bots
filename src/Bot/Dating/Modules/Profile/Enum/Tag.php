<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Profile\Enum;

enum Tag: int
{
    case Relationships = 1;
    case Communication = 2;
    case Sex = 3;
    case Sponsorship = 4;
    case Vacation = 5;
    case Friendship = 6;
    case Party = 7;
    case Dating = 8;
}
