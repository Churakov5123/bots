<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Horoscope\Services;

use App\Bot\Dating\Modules\Horoscope\Enum\Calendar;
use App\Bot\Dating\Modules\Horoscope\Object\HoroscopeValueObject;
use Exception;

class CalculateHoroscope
{
    private const END_DAY = '23:59:59';

    private const ASTROLOGY_CALENDAR = [
        ['name' => 'aries',
            'key' => 1, 'unicode' => '♈', 'start' => '03-21', 'end' => '04-20', 'description' => 'Любят говорить правду в лицо, очень упрямы',
        ],
        ['name' => 'taurus',
            'key' => 2, 'unicode' => '♉', 'start' => '04-21', 'end' => '05-21', 'description' => 'Пока спокоен, демонстрирует мягкость, терпение.',
        ],
        ['name' => 'gemini',
            'key' => 3, 'unicode' => '♊', 'start' => '05-22', 'end' => '06-21', 'description' => 'Многие сочтут их лицемерами, но Близнецы лишь путают сами себя, потому что не могут выбирать четкой позиции в жизни.',
        ],
        ['name' => 'cancer',
            'key' => 4, 'unicode' => '♋', 'start' => '06-22', 'end' => '07-22', 'description' => 'Среди главных страхов представителей знака — страх бедности. Раки очень домашние, любят и умеют заботиться о близких.',
        ],
        ['name' => 'leo',
            'key' => 5, 'unicode' => '♌', 'start' => '07-23', 'end' => '08-23', 'description' => 'Львы отважны, щедры, благородны и могут пожертвовать собой ради других.',
        ],
        ['name' => 'virgo',
            'key' => 6, 'unicode' => '♍', 'start' => '08-24', 'end' => '09-23', 'description' => 'Поддерживают порядок в деньгах, делах и доме, практичны и домовиты.',
        ],
        ['name' => 'libra',
            'key' => 7, 'unicode' => '♎', 'start' => '09-24', 'end' => '10-23', 'description' => 'Весы любят, когда их хвалят, но не выносят критику. Редко проявляют оригинальность, стараются не брать на себя лишней ответственности.',
        ],
        ['name' => 'scorpio',
            'key' => 8, 'unicode' => '♏', 'start' => '10-24', 'end' => '11-22', 'description' => 'Скорпионы любят жить, как говорится, на полную катушку, крайне азартны, склонны к зависимостям, категоричны. Людям чаще не доверяют и создают трагедию на пустом месте.',
        ],
        ['name' => 'sagittarius',
            'key' => 9, 'unicode' => ' ♐', 'start' => '11-23', 'end' => '12-21', 'description' => 'У представителей этого знака хорошо развита сила воли, они решительны и слегка воинственны, любят всех поучать.',
        ],
        ['name' => 'capricorn',
            'key' => 10, 'unicode' => '♑', 'start' => '12-22', 'end' => '01-20', 'description' => 'Рисковать Козерог не любит, может стать закоренелым пессимистом и закрыться из-за неуверенности в себе.',
        ],
        ['name' => 'aquarius',
            'key' => 11, 'unicode' => '♒', 'start' => '01-21', 'end' => '02-19', 'description' => 'Налет романтики мешает Водолею трезво смотреть на мир. Зато не мешает быть ярким, неординарным.',
        ],
        ['name' => 'pisces',
            'key' => 12, 'unicode' => '♓', 'start' => '02-20', 'end' => '03-20', 'description' => 'В быту неприхотливы, уравновешены, умеют скрывать чувства и часто манипулируют другими людьми. Тщеславие и меркантильность не присущи водному знаку, они умеют работать, но не рвутся к славе.',
        ],
    ];

    private const CHINESE_CALENDAR = [
        ['name' => 'rat', 'key' => 1, 'unicode' => '鼠', 'years' => [2020, 2008, 1996, 1984, 1972, 1960, 1948, 1936], 'description' => 'Талантливы, делают все с оптимизмом и страстью. '],
        ['name' => 'ox', 'key' => 2, 'unicode' => '牛', 'years' => [2021, 2009, 1997, 1985, 1973, 1961, 1949, 1937], 'description' => 'Трудолюбивый и выносливый знак.'],
        ['name' => 'tiger', 'key' => 3, 'unicode' => '兎', 'years' => [2022, 2010, 1998, 1986, 1974, 1962, 1950, 1938], 'description' => 'Символ благородства, смелости и независимости. '],
        ['name' => 'rabbit', 'key' => 4, 'unicode' => '兔', 'years' => [2023, 2011, 1999, 1987, 1975, 1963, 1951, 1939], 'description' => 'Добрый, воспитанный, рассудительный и осторожный.'],
        ['name' => 'dragon', 'key' => 5, 'unicode' => '龍', 'years' => [2024, 2012, 2000, 1988, 1976, 1964, 1952, 1940], 'description' => 'Им свойственны проницательность и сентиментальность.'],
        ['name' => 'snake', 'key' => 6, 'unicode' => '蛇', 'years' => [2025, 2013, 2001, 1989, 1977, 1965, 1953, 1941], 'description' => 'Люди, которые удивляют своей интуицией и дипломатичностью, и при этом весьма непостоянны.'],
        ['name' => 'horse', 'key' => 7, 'unicode' => '馬', 'years' => [2026, 2014, 2002, 1990, 1978, 1966, 1954, 1942], 'description' => 'Люди, жаждущие приключений, способные на любые авантюры'],
        ['name' => 'goat', 'key' => 8, 'unicode' => '羊', 'years' => [2027, 2015, 2003, 1991, 1979, 1967, 1955, 1943], 'description' => 'Xарактеризуется щедростью и нерешительностью'],
        ['name' => 'monkey', 'key' => 9, 'unicode' => '猴', 'years' => [2028, 2016, 2004, 1992, 1980, 1968, 1956, 1944], 'description' => 'Умная личность, интеллектуал'],
        ['name' => 'rooster', 'key' => 10, 'unicode' => '雞', 'years' => [2029, 2017, 2005, 1993, 1981, 1969, 1957, 1945], 'description' => 'Oбладают прямолинейностью, практичностью и трудолюбием'],
        ['name' => 'dog', 'key' => 11, 'unicode' => '狗', 'years' => [2030, 2018, 2006, 1994, 1982, 1970, 1958, 1946], 'description' => 'Oтличается скромностью и преданность второй половинке.'],
        ['name' => 'pig', 'key' => 12, 'unicode' => '豬', 'years' => [2031, 2019, 2007, 1995, 1983, 1971, 1959, 1947], 'description' => 'Щедрый человек, вспыльчивый, но отходчивый'],
    ];

    private \DateTime $userDate;

    public function __construct(\DateTime $userDate)
    {
        $this->userDate = $userDate;
    }

    /**
     * @throws Exception
     */
    public function getAstrologyHoroscope(): HoroscopeValueObject
    {
        $year = date('Y');
        $date = strtotime(sprintf('%s-%s', date('Y'), $this->userDate->format('m-d')));

        foreach (self::ASTROLOGY_CALENDAR as $zodiac) {
            if (
                $date >= strtotime($year.'-'.$zodiac['start']) &&
                $date <= strtotime($year.'-'.$zodiac['end'].' '.self::END_DAY)
            ) {
                return new HoroscopeValueObject(
                    $zodiac['name'],
                    $zodiac['key'],
                    $zodiac['unicode'],
                    $zodiac['start'],
                    $zodiac['end'],
                    Calendar::from(Calendar::Astrology->value),
                    $zodiac['description'],
                );
            }
        }

        foreach (array_slice(self::ASTROLOGY_CALENDAR, 9, 2) as $zodiac) {
            if (
                $date >= strtotime(($year).'-'.$zodiac['start']) &&
                $date <= strtotime(($year + 1).'-'.$zodiac['end'].' '.self::END_DAY)
            ) {
                return new HoroscopeValueObject(
                    $zodiac['name'],
                    $zodiac['key'],
                    $zodiac['unicode'],
                    $zodiac['start'],
                    $zodiac['end'],
                    Calendar::from(Calendar::Astrology->value),
                    $zodiac['description'],
                );
            }

            if (
                $date >= strtotime(($year - 1).'-'.$zodiac['start']) &&
                $date <= strtotime(($year).'-'.$zodiac['end'].' '.self::END_DAY)
            ) {
                return new HoroscopeValueObject(
                    $zodiac['name'],
                    $zodiac['key'],
                    $zodiac['unicode'],
                    $zodiac['start'],
                    $zodiac['end'],
                    Calendar::from(Calendar::Astrology->value),
                    $zodiac['description'],
                );
            }
        }

        throw new Exception('AstrologyHoroscope is not found');
    }

    /**
     * @throws Exception
     */
    public function getChineseHoroscope(): HoroscopeValueObject
    {
        foreach (self::CHINESE_CALENDAR as $sign) {
            if (in_array($this->userDate->format('Y'), $sign['years'])) {
                return new HoroscopeValueObject(
                    $sign['name'],
                    $sign['key'],
                    $sign['unicode'],
                    $this->userDate->format('Y'),
                    $this->userDate->format('Y'),
                    Calendar::from(Calendar::Chinese->value),
                    $sign['description'],
                );
            }
        }

        throw new Exception('ChineseHoroscope is not found');
    }
}
