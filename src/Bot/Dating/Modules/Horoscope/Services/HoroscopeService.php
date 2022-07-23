<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Horoscope\Services;

use App\Bot\Dating\Modules\Horoscope\Enum\AstrologyHoroscope;
use App\Bot\Dating\Modules\Horoscope\Enum\ChineseHoroscope;
use App\Bot\Dating\Modules\Horoscope\Object\HoroscopeValueObject;
use App\Bot\Dating\Modules\Horoscope\Services\Interfaces\Horoscope;

class HoroscopeService implements Horoscope
{
    private CalculateHoroscope $calculateHoroscope;
    private MatchAstrologyHoroscope $matchAstrologyZodiac;
    private MatchChineseHoroscope $matchChineseHoroscope;

    public function __construct(\DateTime $date)
    {
        $this->calculateHoroscope = new CalculateHoroscope($date);
        $this->matchAstrologyZodiac = new MatchAstrologyHoroscope();
        $this->matchChineseHoroscope = new MatchChineseHoroscope();
    }

    /**
     * @throws \Exception
     */
    public function getAstrologyHoroscope(): HoroscopeValueObject
    {
        return $this->calculateHoroscope->getAstrologyHoroscope();
    }

    /**
     * @throws \Exception
     */
    public function getAstrologyBestHoroscopeMatch(AstrologyHoroscope $zodiac): ?string
    {
        return $this->matchAstrologyZodiac->getBestMatched(AstrologyHoroscope::from($this->getAstrologyHoroscope()->getKey()),
            $zodiac
        );
    }

    /**
     * @throws \Exception
     */
    public function getAstrologyHoroscopeMatch(AstrologyHoroscope $zodiac): string
    {
        return $this->matchAstrologyZodiac->getMatched(AstrologyHoroscope::from($this->getAstrologyHoroscope()->getKey()),
            $zodiac
        );
    }

    /**
     * @throws \Exception
     */
    public function getChineseHoroscope(): HoroscopeValueObject
    {
        return $this->calculateHoroscope->getChineseHoroscope();
    }

    /**
     * @throws \Exception
     */
    public function getChineseHoroscopeMatch(ChineseHoroscope $sing): string
    {
        return $this->matchChineseHoroscope->getMatched(ChineseHoroscope::from($this->getChineseHoroscope()->getKey()),
            $sing
        );
    }
}
