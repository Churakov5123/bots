<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Feed\Templates;

use App\Bot\Dating\Data\Entity\Profile;
use App\Bot\Dating\Modules\Ad\AdForPrivetMode;

class PrivateTemplateFeed extends AbstractTemplateFeed
{
    protected function getAdvertSet(): array
    {
        return AdForPrivetMode::ADS;
    }

    protected function prepareProfile(Profile $profile, Profile $profileOwner): array
    {
        return $this->transformProfile($profile, $profileOwner)->getProfileForPrivateTemplate();
    }
}
