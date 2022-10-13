<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Feed\Templates;

class PrivateTemplateFeed extends AbstractTemplateFeed
{
    private const ADS = [
    ];

    protected function getAdvertSet(): array
    {
        return self::ADS;
    }
}
