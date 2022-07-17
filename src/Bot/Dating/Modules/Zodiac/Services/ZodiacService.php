<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Zodiac\Services;

use App\Bot\Dating\Modules\Zodiac\Enum\AstrologyZodiac;
use App\Bot\Dating\Modules\Zodiac\Enum\ChineseZodiac;
use App\Bot\Dating\Modules\Zodiac\Enum\TibetZodiac;

class ZodiacService implements Zodiac
{
    protected \DateTime $date;
    protected CalculateZodiac $calculateZodiac;

    public function __construct(\DateTime $date,
    ) {
        $this->date = $date;
        $this->calculateZodiac = new CalculateZodiac($date);
    }

    /**
     * @throws \Exception
     */
    public function getAstrologyZodiac(\DateTime $data): AstrologyZodiac
    {
        $result = $this->calculateZodiac->getAstrologyZodiac();

        return AstrologyZodiac::from($result->getKey());
    }

    public function getAstrologyZodiacMatches(AstrologyZodiac $zodiac): array
    {
        return [];
    }

    public function getChineseZodiac(\DateTime $data): ChineseZodiac
    {
        return ChineseZodiac::from();
    }

    public function getChineseZodiacMatches(ChineseZodiac $zodiac): array
    {
        return [];
    }

    public function getTibetZodiac(\DateTime $data): TibetZodiac
    {
        return TibetZodiac::from();
    }

    public function getTibetZodiacMatches(TibetZodiac $zodiac): array
    {
        return [];
    }
}
