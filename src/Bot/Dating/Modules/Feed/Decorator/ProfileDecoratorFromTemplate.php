<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Feed\Decorator;

use App\Bot\Dating\Data\Entity\Profile;
use App\Bot\Dating\Modules\Horoscope\Services\HoroscopeService;

class ProfileDecoratorFromTemplate
{
    private Profile $profile;
    private HoroscopeService $horoscopeService;

    public function setProfile(Profile $profile): void
    {
        $this->profile = $profile;
    }

    public function setHoroscopeService(HoroscopeService $horoscopeService): void
    {
        $this->horoscopeService = $horoscopeService;
    }

    public function getProfileForBaseTemplate(): array
    {
        $horoscopeForIncomeProfile = new HoroscopeService(new \DateTime($this->profile->getBirthDate()));
        $searchDiapazone = $this->profile->getSearchAgeDiapazone();

        return [
            'id' => $this->profile->getId(),
            'images' => $this->profile->getImages(),
            'lastActivity' => $this->profile->getLastActivity(),
            'name' => $this->profile->getName(),
            'gender' => $this->profile->getGender()->name,
            'age' => $this->profile->getAge(),
            'city' => $this->profile->getCity(), // поиск будет пока по одному городу для тестировния.
            'searchAgeDiapazone' => sprintf('Люди в возрасте от %s до %s лет', $searchDiapazone[0], $searchDiapazone[1]),
            'description' => $this->profile->getDescription(),
            'astrologyHoroscope' => $horoscopeForIncomeProfile->getAstrologyHoroscope()->getData(),
            'matchAstrologyHoroscope' => $this->horoscopeService->getAstrologyHoroscopeMatch($this->profile->getAstrologyHoroscope()),
            'chineseHoroscope' => $horoscopeForIncomeProfile->getChineseHoroscope()->getData(),
            'matchChineseHoroscope' => $this->horoscopeService->getChineseHoroscopeMatch($this->profile->getChineseHoroscope()),
            'hobby' => $this->profile->getHobby(),
        ];
    }

    public function getProfileForPrivateTemplate(): array
    {
        $horoscopeForIncomeProfile = new HoroscopeService(new \DateTime($this->profile->getBirthDate()));
        $searchDiapazone = $this->profile->getSearchAgeDiapazone();

        return [
            'id' => $this->profile->getId(),
            'images' => $this->profile->getImages(),
            'lastActivity' => $this->profile->getLastActivity(),
            'name' => $this->profile->getName(),
            'gender' => $this->profile->getGender()->name,
            'tag' => sprintf('Интересует : %s', $this->profile->getTag()->name),
            'couple' => sprintf('Ищет - %s', $this->profile->getCouple()->name),
            'age' => $this->profile->getAge(),
            'city' => $this->profile->getCity(), // поиск будет пока по одному городу для тестировния.
            'description' => $this->profile->getDescription(),
            'searchAgeDiapazone' => sprintf('Люди в возрасте от %s до %s лет', $searchDiapazone[0], $searchDiapazone[1]),
            'astrologyHoroscope' => $horoscopeForIncomeProfile->getAstrologyHoroscope()->getData(),
            'matchAstrologyHoroscope' => $this->horoscopeService->getAstrologyHoroscopeMatch($this->profile->getAstrologyHoroscope()),
            'chineseHoroscope' => $horoscopeForIncomeProfile->getChineseHoroscope()->getData(),
            'matchChineseHoroscope' => $this->horoscopeService->getChineseHoroscopeMatch($this->profile->getChineseHoroscope()),
            'hobby' => $this->profile->getHobby(),
        ];
    }
}
