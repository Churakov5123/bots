<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Horoscope\Services;

use App\Bot\Dating\Modules\Horoscope\Object\HoroscopeValueObject;
use App\Bot\Dating\Modules\Horoscope\Enum\Calendar;
use Exception;

class CalculateHoroscope
{
    private const END_DAY = '23:59:59';

    private const ASTROLOGY_CALENDAR = [
        ['name' => 'aries',
            'key' => 1, 'unicode' => '♈', 'start' => '03-21', 'end' => '04-20',
        ],
        ['name' => 'taurus',
            'key' => 2, 'unicode' => '♉', 'start' => '04-21', 'end' => '05-21',
        ],
        ['name' => 'gemini',
            'key' => 3, 'unicode' => '♊', 'start' => '05-22', 'end' => '06-21',
        ],
        ['name' => 'cancer',
            'key' => 4, 'unicode' => '♋', 'start' => '06-22', 'end' => '07-22',
        ],
        ['name' => 'leo',
            'key' => 5, 'unicode' => '♌', 'start' => '07-23', 'end' => '08-23',
        ],
        ['name' => 'virgo',
            'key' => 6, 'unicode' => '♍', 'start' => '08-24', 'end' => '09-23',
        ],
        ['name' => 'libra',
            'key' => 7, 'unicode' => '♎', 'start' => '09-24', 'end' => '10-23',
        ],
        ['name' => 'scorpio',
            'key' => 8, 'unicode' => '♏', 'start' => '10-24', 'end' => '11-22',
        ],
        ['name' => 'sagittarius',
            'key' => 9, 'unicode' => ' ♐', 'start' => '11-23', 'end' => '12-21',
        ],
        ['name' => 'capricorn',
            'key' => 10, 'unicode' => '♑', 'start' => '12-22', 'end' => '01-20',
        ],
        ['name' => 'aquarius',
            'key' => 11, 'unicode' => '♒', 'start' => '01-21', 'end' => '02-19',
        ],
        ['name' => 'pisces',
            'key' => 12, 'unicode' => '♓', 'start' => '02-20', 'end' => '03-20',
        ]
    ];

    private const CHINESE_CALENDAR = [
        ['name' => 'monkey', 'unicode' => '猴'],
        ['name' => 'rooster', 'unicode' => '雞'],
        ['name' => 'dog', 'unicode' => '狗'],
        ['name' => 'pig', 'unicode' => '豬'],
        ['name' => 'rat', 'unicode' => '鼠'],
        ['name' => 'ox', 'unicode' => '牛'],
        ['name' => 'tiger', 'unicode' => '兎'],
        ['name' => 'rabbit', 'unicode' => '兔'],
        ['name' => 'dragon', 'unicode' => '龍'],
        ['name' => 'serpent', 'unicode' => '蛇'],
        ['name' => 'horse', 'unicode' => '馬'],
        ['name' => 'goat', 'unicode' => '羊'],
    ];

    private const TIBET_CALENDAR = [
        'lug',
        'glang',
        'khrigpa',
        'karkata',
        'sengge',
        'bumo',
        'srang',
        'sdigpa',
        'gzhu',
        'chusrin',
        'bumpa',
        'nya',
    ];

    private \DateTime $userDate;

    public function __construct(\DateTime $userDate)
    {
        $this->userDate = $userDate;
    }

    /**
     * @throws Exception
     */
    public function getAstrologyZodiac(): HoroscopeValueObject
    {
        $year = date('Y');
        $date = strtotime(sprintf('%s-%s', date('Y'), $this->userDate->format('m-d')));

        foreach (self::ASTROLOGY_CALENDAR as $zodiac) {
            if (
                $date >= strtotime($year . '-' . $zodiac['start']) &&
                $date <= strtotime($year . '-' . $zodiac['end'] . self::END_DAY)
            ) {
                return new HoroscopeValueObject(
                    $zodiac['name'],
                    $zodiac['key'],
                    $zodiac['unicode'],
                    $zodiac['start'],
                    $zodiac['end'],
                    Calendar::from(Calendar::Astrology->value),
                );
            }
        }

        throw new Exception('HoroscopeValueObject is not found');
    }

    /**
     * @throws Exception
     */
    public function getChineseZodiac(): HoroscopeValueObject
    {
        throw new Exception('HoroscopeValueObject is not found');
    }
}
