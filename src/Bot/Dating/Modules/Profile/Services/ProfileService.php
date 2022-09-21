<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Profile\Services;

use App\Bot\Dating\Data\Entity\Profile;
use App\Bot\Dating\Modules\Horoscope\Enum\AstrologyHoroscope;
use App\Bot\Dating\Modules\Horoscope\Enum\ChineseHoroscope;
use App\Bot\Dating\Modules\Horoscope\Services\HoroscopeService;
use App\Bot\Dating\Modules\Image\Services\ImageHandler;
use App\Bot\Dating\Modules\Profile\Dto\CreateProfileDto;
use App\Bot\Dating\Modules\Profile\Dto\ProfileDto;
use App\Bot\Dating\Modules\Profile\Repository\ProfileRepository;
use Exception;

class ProfileService
{
    public function __construct(
        private ProfileRepository $profileRepository,
        private ImageHandler $imageHandler,
    ) {
    }

    /**
     * @throws Exception
     */
    public function make(CreateProfileDto $dto): Profile
    {
        $result = $this->profileRepository->getProfileByLogin($dto->getLogin());

        if (null !== $result) {
            throw new Exception('Profile all ready exist', 403);
        }

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
                /* @var  string $image */
                $this->imageHandler->execute($newProfile, $dto, $image);
            }
        }

        return $newProfile;
    }

    /**
     * @throws Exception
     */
    public function update(ProfileDto $dto): Profile
    {
        $profile = $this->read($dto->getId());

        $profile->setAge();
        $profile->setBirthDate();
        $profile->setCity();
        $profile->setCountryCode();
        $profile->setCouple();
        $profile->setDescription();
        $profile->setGender();
        $profile->setHobby();
        $profile->setImages();
        $profile->setLang();
        $profile->setLocale();
        $profile->setLogin();
        $profile->setPlatform();
        $profile->setName();
        $profile->setSearchAgeDiapazone();
        $profile->setSearchMode();
        $profile->setTag();

        $this->profileRepository->save($profile);

        if (null !== $dto->getImages()) {
            $this->imageHandler->deleteImages($profile);

            foreach ($dto->getImages() as $image) {
                /* @var string $image */
                $this->imageHandler->execute($profile, $dto, $image);
            }
        }

        return $profile;
    }

    /**
     * @throws Exception
     */
    public function read(string $id): Profile
    {
        /** @var Profile $profile */
        $profile = $this->profileRepository->find($id);

        if (null === $profile) {
            throw new Exception('Profile not found', 404);
        }

        return $profile;
    }

    /**
     * @throws Exception
     */
    public function deactivate(string $id): void
    {
        $profile = $this->read($id);

        if (!$profile->isActive()) {
            throw new Exception('Profile already not active', 200);
        }

        $profile->setActive(false);

        $this->profileRepository->save($profile);
    }

    /**
     * @throws Exception
     */
    public function activate(string $id): void
    {
        $profile = $this->read($id);

        if ($profile->isActive()) {
            throw new Exception('Profile is active', 200);
        }

        $profile->setActive(true);

        $this->profileRepository->save($profile);
    }

    /**
     * @throws Exception
     */
    public function delete(string $id): void
    {
        try {
            /** @var Profile $profile */
            $profile = $this->read($id);
            // удалить все фото
            $this->imageHandler->deleteImages($profile);
            // удалить все записи в таблице картинок
            $this->profileRepository->remove($profile);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
