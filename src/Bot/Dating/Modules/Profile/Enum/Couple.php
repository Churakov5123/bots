<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Profile\Enum;

enum Couple: int
{
    case Male = 1;
    case Female = 2;
    case Transsexual = 3;
    case Lesbian = 4;
    case Homosexual = 5;
    case Bisexual = 6;
}
