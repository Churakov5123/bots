<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Profile\Services;

use App\Bot\Dating\Data\Entity\Profile;
use App\Bot\Dating\Modules\Profile\Dto\CreateProfileDto;
use App\Bot\Dating\Modules\Profile\Repository\ProfileRepository;

class CreateProfileService
{
    public function __construct(private ProfileRepository $profileRepository
    ) {
    }

    public function make(CreateProfileDto $dto): Profile
    {
        $newProfile = new Profile(
            $dto->login,
            $dto->name,
            $dto->birthDate,
            $dto->countryCode,
            $dto->city,
            $dto->gender,
            $dto->platform,
            $dto->couple,
            $dto->zodiac,
            $dto->tags,
            $dto->description,
            $dto->media,
        );

        $this->profileRepository->save($newProfile);

        return $newProfile;
    }
}
