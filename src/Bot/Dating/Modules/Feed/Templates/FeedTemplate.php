<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Feed\Templates;

interface FeedTemplate
{
    public function prepareData(array $profiles): array;
}
