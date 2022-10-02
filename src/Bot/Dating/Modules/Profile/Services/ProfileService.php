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
    public function make(CreateProfileDto $dto, bool $isFake = false): Profile
    {
        $result = $this->profileRepository->getProfileByLogin($dto->getLogin());

        if (null !== $result) {
            throw new Exception('Profile all ready exist', 403);
        }

        try {
            $horoscope = new HoroscopeService($dto->getBirthDate());
            $astrologyHoroscope = AstrologyHoroscope::from($horoscope->getAstrologyHoroscope()->getKey());
            $chineseHoroscope = ChineseHoroscope::from($horoscope->getChineseHoroscope()->getKey());
            // еще будет сервис по таро - получение карты для последующей сверки ------
        } catch (\Exception $e) {
            dd($e);
        }

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

        $newProfile->setFake($isFake);

        if (null !== $dto->getImages()) {
            foreach ($dto->getImages() as $image) {
                /* @var  string $image */
                $this->imageHandler->execute($newProfile, $dto, $image);
            }
        }

        $this->profileRepository->save($newProfile);

        return $newProfile;
    }

    /**
     * @throws Exception
     */
    public function update(Profile $profile, ProfileDto $dto): Profile
    {
        $profile->setAge($dto->getBirthDate());
        $profile->setBirthDate($dto->getBirthDate());
        $profile->setCity($dto->getCity());
        $profile->setCountryCode($dto->getCountryCode());
        $profile->setCouple($dto->getCouple());
        $profile->setDescription($dto->getDescription());
        $profile->setGender($dto->getGender());
        $profile->setHobby($dto->getHobby());
        $profile->setLang($dto->getLang());
        $profile->setLocale($dto->getLocale());
        $profile->setLogin($dto->getLogin());
        $profile->setPlatform($dto->getPlatform());
        $profile->setName($dto->getName());
        $profile->setSearchAgeDiapazone($dto->getSearchAgeDiapazone());
        $profile->setSearchMode($dto->getSearchMode());
        $profile->setTag($dto->getTag());

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
