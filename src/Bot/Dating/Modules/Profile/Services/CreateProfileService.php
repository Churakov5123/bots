<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Profile\Services;

use App\Bot\Dating\Data\Entity\Profile;
use App\Bot\Dating\Modules\Horoscope\Enum\AstrologyHoroscope;
use App\Bot\Dating\Modules\Horoscope\Enum\ChineseHoroscope;
use App\Bot\Dating\Modules\Horoscope\Services\HoroscopeService;
use App\Bot\Dating\Modules\Image\Services\ImageHandler;
use App\Bot\Dating\Modules\Profile\Dto\CreateProfileDto;
use App\Bot\Dating\Modules\Profile\Repository\ProfileRepository;

class CreateProfileService
{
    public function __construct(
        private ProfileRepository $profileRepository,
        private ImageHandler $imageHandler,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function make(CreateProfileDto $dto): Profile
    {
        $horoscope = new HoroscopeService($dto->getBirthDate());
        $astrologyHoroscope = AstrologyHoroscope::from($horoscope->getAstrologyHoroscope()->getKey());
        $chineseHoroscope = ChineseHoroscope::from($horoscope->getChineseHoroscope()->getKey());
        // еще будет сервис по таро - получение карты для последующей сверки ------
        $newProfile = new Profile(
            $dto->getLogin(),
            $dto->getName(),
            $dto->getBirthDate(),
            $astrologyHoroscope,
            $chineseHoroscope,
            $dto->getCountryCode(),
            $dto->getCity(),
            $dto->getGender(),
            $dto->getPlatform(),
            $dto->getCouple(),
            $dto->getSearchAgeDiapazone(),
            $dto->getTag(),
            $dto->getDescription(),
            $dto->getHobby(),
        );

        $this->profileRepository->save($newProfile);

        if (null !== $dto->getImages()) {
            foreach ($dto->getImages() as $image) {
                /* @var  $image */
                // тут нужно или получать уже отвалидированный или отвалидировать  $image
                // и пустить далее в виде обьекта чтобы с ним можно былдо работать
                $this->imageHandler->execute($newProfile, $dto, $image);
            }
        }

        return $newProfile;
    }
}
