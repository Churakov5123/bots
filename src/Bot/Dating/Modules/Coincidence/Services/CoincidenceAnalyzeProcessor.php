<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Coincidence\Services;

use App\Bot\Dating\Data\Entity\Coincidence;

class CoincidenceAnalyzeProcessor
{
    public function __construct(
        private CoincidenceService $coincidenceService,
    ) {
    }

    public function execute(): void
    {
        $this->coincidenceService->calculateCoincidences();
        $matches = $this->coincidenceService->getNotSendMatches();

        if (empty($matches)) {
            return;
        }

        /** @var Coincidence $match */
        foreach ($matches as $match) {
            // отправляем в очередь рэбита на отпрвку нотификаций ( и после изменение статуса на отправленное!
        }
    }
}
