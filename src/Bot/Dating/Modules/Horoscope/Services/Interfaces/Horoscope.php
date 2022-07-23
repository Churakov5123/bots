<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Horoscope\Services\Interfaces;

use App\Bot\Dating\Modules\Horoscope\Enum\AstrologyHoroscope;
use App\Bot\Dating\Modules\Horoscope\Enum\ChineseHoroscope;
use App\Bot\Dating\Modules\Horoscope\Object\HoroscopeValueObject;

interface Horoscope
{
    public function getAstrologyHoroscope(): HoroscopeValueObject;

    public function getAstrologyBestHoroscopeMatch(AstrologyHoroscope $zodiac): ?string;

    public function getAstrologyHoroscopeMatch(AstrologyHoroscope $zodiac): string;

    public function getChineseHoroscope(): HoroscopeValueObject;

    public function getChineseHoroscopeMatch(ChineseHoroscope $sing): string;
}
