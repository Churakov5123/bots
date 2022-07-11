<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Profile\Dto;

class ProfileDto extends CreateProfileDto
{
    private string $id;

    public function getId(): string
    {
        return $this->id;
    }
}
