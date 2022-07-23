<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Profile\Services;

use App\Bot\Dating\Data\Entity\Profile;
use App\Bot\Dating\Modules\Horoscope\Enum\ChineseHoroscope;
use App\Bot\Dating\Modules\Horoscope\Services\HoroscopeService;
use App\Bot\Dating\Modules\Profile\Dto\CreateProfileDto;
use App\Bot\Dating\Modules\Profile\Repository\ProfileRepository;

class CreateProfileService
{
    public function __construct(private ProfileRepository $profileRepository,
    ) {
    }

    public function make(CreateProfileDto $dto): Profile
    {
        $horoscope = new HoroscopeService($dto->getBirthDate());
//        dump($horoscope->getAstrologyHoroscope());
//        dump($horoscope->getChineseHoroscope());
//        dump(ChineseHoroscope::from(1));
//        dd($horoscope->getChineseHoroscopeMatch(ChineseHoroscope::from(1)));

        $newProfile = new Profile(
            $dto->getLogin(),
            $dto->getName(),
            $dto->getBirthDate(),
            $horoscope->getAstrologyHoroscope(),
            $dto->getCountryCode(),
            $dto->getCity(),
            $dto->getGender(),
            $dto->getPlatform(),
            $dto->getCouple(),
            $dto->getTag(),
            $dto->getDescription(),
            $dto->getMedia(),
            $dto->getHobby(),
        );

        $this->profileRepository->save($newProfile);

        return $newProfile;
    }
}
