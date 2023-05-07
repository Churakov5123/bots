<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Profile\Services;

use App\Bot\Dating\Data\Entity\Profile;
use App\Bot\Dating\Modules\Feed\Templates\FeedTemplate;
use App\Bot\Dating\Modules\Horoscope\Enum\AstrologyHoroscope;
use App\Bot\Dating\Modules\Horoscope\Enum\ChineseHoroscope;
use App\Bot\Dating\Modules\Horoscope\Services\HoroscopeService;
use App\Bot\Dating\Modules\Image\Services\ImageHandler;
use App\Bot\Dating\Modules\Profile\Dto\CreateProfileDto;
use App\Bot\Dating\Modules\Profile\Dto\ProfileDto;
use App\Bot\Dating\Modules\Profile\Repository\ProfileRepository;
use Exception;

/**
 * This class is responsible for creating, reading, updating, and deleting dating profiles in the system.
 *
 * In the make() method, a new Profile is created and saved to the database. It contains information about the user's name, birth date, horoscope, location, gender, images, and other profile details.
 *
 * The update() method updates the user's profile in the database with new information.
 *
 * The read() method returns a Profile object with the specified ID.
 *
 * The deactivate() and activate() methods change the active flag of the profile to false or true, respectively.
 *
 * Finally, the delete() method removes the profile from the database.
 *
 * Note that the code also includes some error handling with Exception thrown when necessary.
 */
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
        $profile->setLastActivity(new \DateTimeImmutable());

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
        $profile->setLastActivity(new \DateTimeImmutable());

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
        $profile->setLastActivity(new \DateTimeImmutable());

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

    public function addLastActivity(Profile $profile): Profile
    {
        $profile->setLastActivity(new \DateTimeImmutable());

        $this->profileRepository->save($profile);

        return $profile;
    }

    /**
     * @throws \Exception
     */
    public function getDataForTemplate(FeedTemplate $template, array $params): array
    {
        if ($template->isBaseTemplate()) {
            return $this->profileRepository->getListForBaseTemplate($params);
        }

        if ($template->isPrivateTemplate()) {
            return $this->profileRepository->getListForPrivateTemplate($params);
        }

        throw new \Exception('Template feed is not supported');
    }
}
