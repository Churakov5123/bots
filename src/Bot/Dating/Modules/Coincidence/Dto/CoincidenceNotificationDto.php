<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Coincidence\Dto;

class CoincidenceNotificationDto
{
    public function __construct(
        private array $payload
    ) {
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function setPayload(array $payload): void
    {
        $this->payload = $payload;
    }
}
