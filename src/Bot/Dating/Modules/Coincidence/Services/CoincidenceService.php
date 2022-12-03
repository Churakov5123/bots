<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Coincidence\Services;

use App\Bot\Dating\Data\Entity\Coincidence;
use App\Bot\Dating\Data\Entity\CoincidenceActivity;
use App\Bot\Dating\Data\Entity\Profile;
use App\Bot\Dating\Modules\Coincidence\Dto\ReadFeedDto;
use App\Bot\Dating\Modules\Coincidence\Repository\CoincidenceActivityRepository;
use App\Bot\Dating\Modules\Coincidence\Repository\CoincidenceRepository;
use App\Bot\Dating\Modules\Profile\Repository\ProfileRepository;

class CoincidenceService
{
    public function __construct(
        private CoincidenceActivityRepository $coincidenceActivityRepository,
        private CoincidenceRepository $coincidenceRepository,
        private ProfileRepository $profileRepository
    ) {
    }

    public function makeCoincidenceActivity(Profile $profile, ReadFeedDto $dto): void
    {
        if (null !== $dto->getProfileId() && null !== $dto->getResolution()) {
            $coincidenceActivity = new CoincidenceActivity($profile, $dto->getProfileId(), $dto->getResolution());
            $this->coincidenceActivityRepository->save($coincidenceActivity);

            $profile->addCoincidenceActivities($coincidenceActivity);
            $this->profileRepository->save($profile);
        }
    }

    public function calculateCoincidences(): void
    {
        // оптимизировть итераторами - чтоб небвло переполнения по памяти.
        $coincidenceActivitiesLastFiftyMinutes = $this->coincidenceActivityRepository->getAllByLastFiftyMinutes(); // с группированный по всем выбирающим юрезмерам! за последние 30 минут
        $coincidenceActivitiesLastMonth = $this->coincidenceActivityRepository->getAllByLastMonth(); // с группированный по всем выбирающим юрезмерам! за последний месяц

        foreach ($coincidenceActivitiesLastFiftyMinutes as $coincidenceActivities) {
            /** @var CoincidenceActivity $coincidenceActivity */
            foreach ($coincidenceActivities as $coincidenceActivity) {
                if ($coincidenceActivity->isLike()) {
                    $result = $this->findMatch(
                        $coincidenceActivity->getChooseProfile(),
                        $coincidenceActivity->getChosenProfile(),
                        $coincidenceActivitiesLastMonth
                    );

                    if ($result) {
                        $coincidence = new Coincidence(
                            $coincidenceActivity->getChooseProfile(),
                            $coincidenceActivity->getChosenProfile()
                        );
                        $this->coincidenceRepository->save($coincidence);
                    }
                }
            }
        }
    }

    private function findMatch(
        Profile $chooseProfile,
        string $chosenProfile,
        array $coincidenceActivitiesLastMonth
    ): bool {
        if (empty($coincidenceActivitiesLastMonth[$chosenProfile])) {
            return false;
        }

        /** @var CoincidenceActivity $coincidenceActivity */
        foreach ($coincidenceActivitiesLastMonth[$chosenProfile] as $coincidenceActivity) {
            if ($coincidenceActivity->getChosenProfile() === $chooseProfile->getId()
                && $coincidenceActivity->isLike()
            ) {
                return true;
            }
        }

        return false;
    }
}
