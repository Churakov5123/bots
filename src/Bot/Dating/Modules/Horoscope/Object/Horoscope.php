<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Horoscope\Object;

interface Horoscope
{
    public function getData(): array;
}
