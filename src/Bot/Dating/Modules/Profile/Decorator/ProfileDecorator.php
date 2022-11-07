<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Profile\Decorator;

use App\Bot\Dating\Data\Entity\Profile;
use App\Bot\Dating\Modules\Horoscope\Services\HoroscopeService;

class ProfileDecorator
{
    public function presentProfile(Profile $profile): array
    {
        $horoscopeForIncomeProfile = new HoroscopeService(new \DateTime($profile->getBirthDate()));
        $searchDiapazone = $profile->getSearchAgeDiapazone();

        return [
            'images' => $profile->getImages(),
            'lastActivity' => $profile->getLastActivity(),
            'name' => $profile->getName(),
            'gender' => $profile->getGender()->name,
            'tag' => sprintf('Интересует : %s', $profile->getTag()->name),
            'couple' => sprintf('Ищет - %s', $profile->getCouple()->name),
            'age' => $profile->getAge(),
            'city' => $profile->getCity(), // поиск будет пока по одному городу для тестировния.
            'description' => $profile->getDescription(),
            'searchAgeDiapazone' => sprintf('Люди в возрасте от %s до %s лет', $searchDiapazone[0], $searchDiapazone[1]),
            'astrologyHoroscope' => $horoscopeForIncomeProfile->getAstrologyHoroscope()->getData(),
            'chineseHoroscope' => $horoscopeForIncomeProfile->getChineseHoroscope()->getData(),
            'hobby' => $profile->getHobby(),
        ];
    }
}
