<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Profile\Dto;

use App\Bot\Dating\Components\Dto\BaseDto;

class CreateProfileDto extends BaseDto
{
    public ?string $login = null;
    public ?string $name = null;
    public ?string $description = null;
    public ?string $birthDate = null;
    public ?string $countryCode = null;
    public ?string $city = null;
    public ?int $gender = null;
    public ?int $couple = null;
    public ?int $zodiac = null;
    public ?int $platform = null;
//
//    private ?array $tags = null;
//    private ?array $media = null;
//    private ?string $lang = null;
//    private ?string $locale = null;
//
//    private ?bool $active = null;
//


    protected function className(): string
    {
        return self::class;
    }
}
