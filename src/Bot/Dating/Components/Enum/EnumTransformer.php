<?php
declare(strict_types=1);

namespace App\Bot\Dating\Components\Enum;

use UnitEnum;

class EnumTransformer
{
    /**
     * @param UnitEnum[] $enums
     *
     * @return array
     */
    public function getEnumValues(array $enums): array
    {
        $data = [];

        foreach ($enums as $enum) {
            $data[] = $enum->value;
        }

        return $data;
    }
}
