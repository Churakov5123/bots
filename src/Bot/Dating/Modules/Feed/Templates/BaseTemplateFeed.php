<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Feed\Templates;

use App\Bot\Dating\Data\Entity\Profile;
use App\Bot\Dating\Modules\Ad\AdForBaseMode;

class BaseTemplateFeed extends AbstractTemplateFeed
{
    protected function getAdvertSet(): array
    {
        return AdForBaseMode::ADS;
    }

    public function prepareProfile(Profile $profile, Profile $profileOwner): array
    {
        return $this->transformProfile($profile, $profileOwner)->getProfileForBaseTemplate();
    }

    public function getName(): string
    {
        return self::BASE_TEMPLATE;
    }
}
