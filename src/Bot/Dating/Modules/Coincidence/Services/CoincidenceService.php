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

    public function getNotSendMatches(): array
    {
        return $this->coincidenceRepository->getNotSendMatches();
    }

    public function calculateCoincidences(): void
    {
        // оптимизировть итераторами - чтоб небвло переполнения по памяти.
        $coincidenceActivitiesLastFiftyMinutes = $this->coincidenceActivityRepository->getAllByLastFiftyMinutes();
        $coincidenceActivitiesLastFiftyMinutes = $this->prepareCoincidence($coincidenceActivitiesLastFiftyMinutes);

        $coincidenceActivitiesLastMonth = $this->coincidenceActivityRepository->getAllByLastMonth();
        $coincidenceActivitiesLastMonth = $this->prepareCoincidence($coincidenceActivitiesLastMonth);

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

    private function prepareCoincidence(array $items): array
    {
        $result = [];

        foreach ($items as $item) {
            $result[$item->getChooseProfile()->getId()][] = $item;
        }

        return $result;
    }
}
