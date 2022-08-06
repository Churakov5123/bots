<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Profile\Enum;

enum SearchMode: int
{
    case Base = 1;
    case Private = 2;
    case AstrologyHoroscope = 3;
    case ChineseHoroscope = 4;
    case Taro = 5;
}
