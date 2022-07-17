<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Zodiac\Dto;

use App\Bot\Dating\Modules\Zodiac\Enum\Calendar;

class ZodiacDto
{
    private ?string $name;
    private ?int $key;
    private ?string $unicode;
    private ?string $start;
    private ?string $end;
    private ?Calendar $calendar;

    public function __construct(
        ?string $name,
        ?int $key,
        ?string $unicode,
        ?string $start,
        ?string $end,
        ?Calendar $calendar
    ) {
        $this->name = $name;
        $this->key = $key;
        $this->unicode = $unicode;
        $this->start = $start;
        $this->end = $end;
        $this->calendar = $calendar;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getKey(): ?int
    {
        return $this->key;
    }

    public function setKey(?int $key): void
    {
        $this->key = $key;
    }

    public function getUnicode(): ?string
    {
        return $this->unicode;
    }

    public function setUnicode(?string $unicode): void
    {
        $this->unicode = $unicode;
    }

    public function getStart(): ?string
    {
        return $this->start;
    }

    public function setStart(?string $start): void
    {
        $this->start = $start;
    }

    public function getEnd(): ?string
    {
        return $this->end;
    }

    public function setEnd(?string $end): void
    {
        $this->end = $end;
    }

    public function isChineseCalendar(): bool
    {
        return $this->calendar->value === Calendar::from(2)->value;
    }

    public function isAstrologyCalendar(): bool
    {
        return $this->calendar->value === Calendar::from(1)->value;
    }
}
