<?php
declare(strict_types=1);

namespace App\Bot\Dating\Modules\Feed\Decorator;

use App\Bot\Dating\Data\Entity\Profile;

class ProfileDecoratorFromTemplate
{
    public function __construct(private Profile $profile,
    )
    {
    }


    public function getProfileForBaseTemplate(Profile $anotherProfile):array
    {
        return [
            'images'=>[],
            'lastActivity'=>,
            'name' => '',
            'gender' => '',
            'age' => '',
            'city' => 'Moscow', // поиск будет пока по одному городу для тестировния.
            'couple' => '',
            'searchAgeDiapazone'=>[],
            'description' => ,
            'hobby' => '',
            'astrologyHoroscope'=>,
            'matchAstrologyHoroscope'=>,
            'chineseHoroscope'=>,
            'matchChineseHoroscope'=>,
        ];
    }

    public function getProfileForPrivateTemplate(Profile $anotherProfile):array
    {
        return [
            'images'=>[],
            'lastActivity'=>,
            'tag'=>,
            'name' => '',
            'gender' => '',
            'age' => '',
            'city' => 'Moscow', // поиск будет пока по одному городу для тестировния.
            'description' =>,
            'couple' => '',
            'searchAgeDiapazone'=>[],
            'astrologyHoroscope'=>,
            'matchAstrologyHoroscope'=>,
            'chineseHoroscope'=>,
            'matchChineseHoroscope'=>,
        ];
    }
}
