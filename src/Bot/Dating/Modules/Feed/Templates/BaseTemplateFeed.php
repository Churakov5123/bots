<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Feed\Templates;

use App\Bot\Dating\Data\Entity\Profile;
use App\Bot\Dating\Modules\Ad\AdForBaseMode;
use App\Bot\Dating\Modules\Ad\Decorator\AdDecorator;
use App\Bot\Dating\Modules\Feed\Decorator\ProfileDecoratorFromTemplate;

class BaseTemplateFeed extends AbstractTemplateFeed
{
    public function __construct(
        ProfileDecoratorFromTemplate $decoratorFromTemplate,
        AdDecorator $adDecorator,
        Profile $profileOwner
    ) {
        parent::__construct($decoratorFromTemplate, $adDecorator, $profileOwner);
    }

    protected function getAdvertSet(): array
    {
        return AdForBaseMode::ADS;
    }

    protected function prepareProfile(Profile $profile, Profile $profileOwner): array
    {
        return $this->transformProfile($profile, $profileOwner)->getProfileForBaseTemplate();
    }
}
