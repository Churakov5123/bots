<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Coincidence\Dto;

use App\Bot\Dating\Components\Dto\BaseDto;

class ReadFeedDto extends BaseDto
{
    protected ?string $profileId = null;
    protected ?bool $resolution = null;

    protected function className(): string
    {
        return self::class;
    }

    public function getProfileId(): ?string
    {
        return $this->profileId;
    }

    public function setProfileId(?string $profileId): void
    {
        $this->profileId = $profileId;
    }

    public function getResolution(): ?bool
    {
        return $this->resolution;
    }

    public function setResolution(?bool $resolution): void
    {
        $this->resolution = $resolution;
    }
}
