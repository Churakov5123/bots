<?php
declare(strict_types=1);

namespace App\Bot\Dating\Modules\Horoscope\Services\Interfaces;

use App\Bot\Dating\Modules\Horoscope\Enum\AstrologyHoroscope;

interface Horoscope
{
    public function getAstrologyHoroscope(): AstrologyHoroscope;

    public function getAstrologyBestHoroscopeMatch(AstrologyHoroscope $zodiac): ?string;

    public function getAstrologyHoroscopeMatch(AstrologyHoroscope $zodiac): string;
}
