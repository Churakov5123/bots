<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Profile\Dto;

use App\Bot\Dating\Components\Dto\BaseDto;

class ReadProfileDto extends BaseDto
{
    protected string $id;

    public function getId(): string
    {
        return $this->id;
    }

    protected function className(): string
    {
        return self::class;
    }
}
