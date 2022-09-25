<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Profile\Dto;

use App\Bot\Dating\Modules\Profile\Enum\SearchMode;

class ProfileDto extends CreateProfileDto
{
    protected ?string $id = null;
    protected ?string $lang = null;
    protected ?string $locale = null;
    protected ?int $searchMode = null;

    protected function className(): string
    {
        return self::class;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getLang(): ?string
    {
        return $this->lang;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function getSearchMode(): ?SearchMode
    {
        return SearchMode::from($this->searchMode);
    }
}
