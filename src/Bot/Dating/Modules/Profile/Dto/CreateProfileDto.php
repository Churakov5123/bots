<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Profile\Dto;

use App\Bot\Dating\Components\Dto\BaseDto;
use App\Bot\Dating\Modules\Profile\Enum\Couple;
use App\Bot\Dating\Modules\Profile\Enum\Gender;
use App\Bot\Dating\Modules\Profile\Enum\Platform;
use App\Bot\Dating\Modules\Profile\Enum\Tag;

class CreateProfileDto extends BaseDto
{
    protected ?string $login = null;
    protected ?string $name = null;
    protected ?string $description = null;
    protected ?string $birthDate = null;
    protected ?string $countryCode = null;
    protected ?string $city = null;
    protected ?int $gender = null;
    protected ?int $couple = null;
    protected ?int $platform = null;
    protected ?int $tag = null;
    protected ?array $images = null;
    protected ?array $hobby = null;

    protected function className(): string
    {
        return self::class;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getBirthDate(): ?\DateTime
    {
        return new \DateTime($this->birthDate);
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getGender(): ?Gender
    {
        return Gender::from($this->gender);
    }

    public function getCouple(): ?Couple
    {
        return Couple::from($this->couple);
    }

    public function getPlatform(): ?Platform
    {
        return Platform::from($this->platform);
    }

    public function getTag(): ?Tag
    {
        return Tag::from($this->platform);
    }

    public function getImages(): ?array
    {
        return $this->images;
    }

    public function getHobby(): ?array
    {
        return $this->hobby;
    }
}
