<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Zodiac\Services;

use App\Bot\Dating\Modules\Zodiac\Enum\AstrologyZodiac;
use App\Bot\Dating\Modules\Zodiac\Enum\ChineseZodiac;
use App\Bot\Dating\Modules\Zodiac\Enum\TibetZodiac;

interface Zodiac
{
    public function getAstrologyZodiac(\DateTime $data): AstrologyZodiac;

    public function getAstrologyZodiacMatches(AstrologyZodiac $targetZodiac, AstrologyZodiac $zodiac): string;

    public function getChineseZodiac(\DateTime $data): ChineseZodiac;

    public function getChineseZodiacMatches(ChineseZodiac $zodiac): array;

    public function getTibetZodiac(\DateTime $data): TibetZodiac;

    public function getTibetZodiacMatches(TibetZodiac $zodiac): array;
}
