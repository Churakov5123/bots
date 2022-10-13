<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Feed\Templates;

abstract class AbstractTemplateFeed implements FeedTemplate
{
    abstract protected function getAdvertSet(): array;

    public function getAdvert(int $number): array
    {
    }
}
