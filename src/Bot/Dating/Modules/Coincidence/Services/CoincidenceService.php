<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Coincidence\Services;

use App\Bot\Dating\Data\Entity\CoincidenceActivity;
use App\Bot\Dating\Data\Entity\Profile;
use App\Bot\Dating\Modules\Coincidence\Dto\ReadFeedDto;
use App\Bot\Dating\Modules\Coincidence\Repository\CoincidenceActivityRepository;
use App\Bot\Dating\Modules\Profile\Repository\ProfileRepository;

class CoincidenceService
{
    public function __construct(
        private CoincidenceActivityRepository $coincidenceRepository,
        private ProfileRepository $profileRepository
    ) {
    }

    public function makeCoincidenceActivity(Profile $profile, ReadFeedDto $dto): void
    {
        if (null !== $dto->getProfileId() && null !== $dto->getResolution()) {
            $coincidenceActivity = new CoincidenceActivity($profile, $dto->getProfileId(), $dto->getResolution());
            $this->coincidenceRepository->save($coincidenceActivity);

            $profile->addCoincidenceActivities($coincidenceActivity);
            $this->profileRepository->save($profile);
        }
    }
}
