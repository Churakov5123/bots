<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Feed\Templates;

use App\Bot\Dating\Data\Entity\Profile;

interface FeedTemplate
{
    public function prepareProfiles(array $profiles): array;

    public function prepareCoincidenceProfile(Profile $profile): array;
}
