<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Coincidence\Services;

use App\Bot\Dating\Data\Entity\Coincidence;
use App\Bot\Dating\Data\Entity\Profile;
use App\Bot\Dating\Modules\Coincidence\Dto\ReadFeedDto;
use App\Bot\Dating\Modules\Coincidence\Repository\CoincidenceRepository;
use App\Bot\Dating\Modules\Profile\Repository\ProfileRepository;

class CoincidenceService
{
    public function __construct(
        private CoincidenceRepository $coincidenceRepository,
        private ProfileRepository $profileRepository
    ) {
    }

    public function makeCoincidence(Profile $profile, ReadFeedDto $dto): void
    {
        if (null !== $dto->getProfileId() && null !== $dto->getResolution()) {
            $coincidence = new Coincidence($profile, $dto->getProfileId(), $dto->getResolution());
            $this->coincidenceRepository->save($coincidence);

            $profile->addCoincidence($coincidence);
            $this->profileRepository->save($profile);
        }
    }
}
