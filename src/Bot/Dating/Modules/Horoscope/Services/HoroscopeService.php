<?php
declare(strict_types=1);

namespace App\Bot\Dating\Modules\Horoscope\Services;

use App\Bot\Dating\Modules\Horoscope\Enum\AstrologyHoroscope;
use App\Bot\Dating\Modules\Horoscope\Services\Interfaces\Horoscope;

class HoroscopeService implements Horoscope
{
    private CalculateHoroscope $calculateZodiac;
    private MatchAstrologyHoroscope $matchAstrologyZodiac;

    public function __construct(\DateTime $date)
    {
        $this->calculateZodiac = new CalculateHoroscope($date);
        $this->matchAstrologyZodiac = new MatchAstrologyHoroscope();
    }

    /**
     * @throws \Exception
     */
    public function getAstrologyHoroscope(): AstrologyHoroscope
    {
        $result = $this->calculateZodiac->getAstrologyZodiac();

        return AstrologyHoroscope::from($result->getKey());
    }

    public function getAstrologyBestHoroscopeMatch(AstrologyHoroscope $zodiac): ?string
    {
        return $this->matchAstrologyZodiac->getBestMatched($this->getAstrologyHoroscope(),$zodiac);
    }

    public function getAstrologyHoroscopeMatch(AstrologyHoroscope $zodiac): string
    {
        return $this->matchAstrologyZodiac->getMatched($this->getAstrologyHoroscope(), $zodiac);
    }
}
