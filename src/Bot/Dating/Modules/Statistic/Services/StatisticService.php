<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Statistic\Services;

use App\Bot\Dating\Data\Entity\Statistic;
use App\Bot\Dating\Modules\Coincidence\Repository\CoincidenceRepository;
use App\Bot\Dating\Modules\Profile\Repository\ProfileRepository;
use App\Bot\Dating\Modules\Statistic\Repository\StatisticRepository;

class StatisticService
{
    public function __construct(
        private ProfileRepository $profileRepository,
        private CoincidenceRepository $coincidenceRepository,
        private StatisticRepository $statisticRepository
    ) {
    }

    public function getStatisticByCurrentTime(): ?Statistic
    {
        return $this->statisticRepository->getStatisticByCurrentTime(new \DateTimeImmutable());
    }

    public function getAllStatistic(): array
    {
        return $this->statisticRepository->findAll();
    }

    public function makeNewStatistic(): void
    {
        $realProfilesCount = count($this->profileRepository->getCreatedProfileBySign(false));
        $fakeProfilesCount = count($this->profileRepository->getCreatedProfileBySign(true));

        $todayRealCount = count($this->profileRepository->getCreatedProfileByCurrentTime(
            new \DateTimeImmutable(),
            false)
        );
        $todayFakeCount = count($this->profileRepository->getCreatedProfileByCurrentTime(
            new \DateTimeImmutable(),
            true)
        );

        $coincidencesCount = count($this->coincidenceRepository->findAll());
        $todayCoincidencesCount = count($this->coincidenceRepository->getCreatedMatchByCurrentTime(new \DateTimeImmutable()));

        $statistic = new Statistic();
        $statistic->setRealCount($realProfilesCount);
        $statistic->setFakeCount($fakeProfilesCount);

        $statistic->setTodayRealCount($todayRealCount);
        $statistic->setTodayFakeCount($todayFakeCount);

        $statistic->setMatchCount($coincidencesCount);
        $statistic->setTodayMatchCount($todayCoincidencesCount);

        $this->statisticRepository->save($statistic);
    }
}
