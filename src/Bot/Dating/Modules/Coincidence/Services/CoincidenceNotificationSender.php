<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Coincidence\Services;

use App\Bot\Dating\Data\Entity\Coincidence;
use App\Bot\Dating\Data\Entity\Profile;
use App\Bot\Dating\Modules\Coincidence\Dto\CoincidenceNotificationDto;
use App\Bot\Dating\Modules\Coincidence\Repository\CoincidenceRepository;
use App\Bot\Dating\Modules\Profile\Repository\ProfileRepository;

class CoincidenceNotificationSender
{
    public function __construct(
        private CoincidenceRepository $coincidenceRepository,
        private ProfileRepository $profileRepository,
        private CoincidenceProfileService $coincidenceProfileService
    ) {
    }

    public function execute(Coincidence $match): void
    {
        $coincidenceNotificationDto = $this->createNotificationDto($match);

        //код отправки сообщений в телеграмм

        //_____________

        $this->markAsSent($match);
    }

    private function createNotificationDto(Coincidence $match): CoincidenceNotificationDto
    {
        $chooseProfile = $match->getChooseProfile();
        /** @var Profile $chosenProfile */
        $chosenProfile = $this->profileRepository->find($match->getChosenProfile());

        $payload = [
            'chooseProfile' => [
                'login' => $chooseProfile->getLogin(),
                'chatId' => '',
                'data' => [
                    'message' => sprintf('У вас есть новая пара с  %s', $chooseProfile->getName()),
                    'profile' => $this->coincidenceProfileService->getPreparedMatch($chooseProfile, $chosenProfile),
                ],
            ],
            'chosenProfile' => [
                'login' => $chosenProfile->getLogin(),
                'chatId' => '',
                'data' => [
                    'message' => sprintf('У вас есть новая пара с  %s', $chosenProfile->getName()),
                    'profile' => $this->coincidenceProfileService->getPreparedMatch($chosenProfile, $chooseProfile),
                ],
            ],
        ];

        return new CoincidenceNotificationDto($payload);
    }

    private function markAsSent(Coincidence $coincidence): void
    {
        $coincidence->setSend(true);
        $this->coincidenceRepository->save($coincidence);
    }
}
