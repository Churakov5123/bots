<?php

declare(strict_types=1);

namespace App\Bot\Dating\Components\Entity;

abstract class ArrayExpressible
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
