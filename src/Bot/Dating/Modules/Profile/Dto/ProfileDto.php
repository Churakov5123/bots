<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Profile\Dto;

class ProfileDto extends CreateProfileDto
{
    protected string $id;
    protected ?int $zodiac = null;
    protected ?array $matchingZodiacs = null;
    protected ?string $lang = null;
    protected ?string $locale = null;
    protected ?bool $active = null;

    public function getId(): string
    {
        return $this->id;
    }
}
