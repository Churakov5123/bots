<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Horoscope\Object;

use App\Bot\Dating\Modules\Horoscope\Enum\Calendar;

class HoroscopeValueObject implements Horoscope
{
    private ?string $name;
    private ?int $key;
    private ?string $unicode;
    private ?string $start;
    private ?string $end;
    private ?Calendar $calendar;
    private ?string $description;

    public function __construct(
        ?string $name,
        ?int $key,
        ?string $unicode,
        ?string $start,
        ?string $end,
        ?Calendar $calendar,
        ?string $description = null
    ) {
        $this->name = $name;
        $this->key = $key;
        $this->unicode = $unicode;
        $this->start = $start;
        $this->end = $end;
        $this->calendar = $calendar;
        $this->description = $description;
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

    public function getCalendar(): ?Calendar
    {
        return $this->calendar;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getData(): array
    {
        return [
            'name' => $this->getName(),
            'key' => $this->getKey(),
            'unicode' => $this->getUnicode(),
            'start' => $this->getStart(),
            'end' => $this->getEnd(),
            'description' => $this->getDescription(),
        ];
    }
}
