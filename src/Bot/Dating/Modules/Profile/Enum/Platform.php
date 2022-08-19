<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Profile\Enum;

enum Platform: int
{
    case Telegram = 1;
    case WeeChat = 2;
    case Facebook = 3;
}
