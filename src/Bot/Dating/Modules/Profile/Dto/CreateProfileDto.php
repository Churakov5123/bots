<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Profile\Dto;

use App\Bot\Dating\Components\Dto\BaseDto;
use App\Bot\Dating\Modules\Profile\Enum\Couple;
use App\Bot\Dating\Modules\Profile\Enum\Gender;
use App\Bot\Dating\Modules\Profile\Enum\Platform;

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
    protected ?array $tags = null;
    protected ?array $media = null;

    protected function className(): string
    {
        return self::class;
    }

    /**
     * @return string|null
     */
    public function getLogin(): ?string
    {
        return $this->login;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return string|null
     */
    public function getBirthDate(): ?string
    {
        return $this->birthDate;
    }

    /**
     * @return string|null
     */
    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @return Gender|null
     */
    public function getGender(): ?Gender
    {
        return Gender::from($this->gender);
    }

    /**
     * @return Couple|null
     */
    public function getCouple(): ?Couple
    {
        return  Couple::from($this->couple);
    }

    /**
     * @return Platform|null
     */
    public function getPlatform(): ?Platform
    {
        return Platform::from($this->platform);
    }

    /**
     * @return array|null
     */
    public function getTags(): ?array
    {
        return $this->tags;
    }

    /**
     * @return array|null
     */
    public function getMedia(): ?array
    {
        return $this->media;
    }
}
