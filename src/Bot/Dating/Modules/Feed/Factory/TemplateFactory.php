<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Feed\Factory;

use App\Bot\Dating\Data\Entity\Profile;
use App\Bot\Dating\Modules\Ad\Decorator\AdDecorator;
use App\Bot\Dating\Modules\Feed\Decorator\ProfileDecoratorFromTemplate;
use App\Bot\Dating\Modules\Feed\Templates\BaseTemplateFeed;
use App\Bot\Dating\Modules\Feed\Templates\FeedTemplate;
use App\Bot\Dating\Modules\Feed\Templates\PrivateTemplateFeed;
use App\Bot\Dating\Modules\Profile\Enum\SearchMode;

class TemplateFactory
{
    public function getTemplate(SearchMode $searchMode, Profile $profile): FeedTemplate
    {
        if (SearchMode::Base->name === $searchMode->name) {
            return new BaseTemplateFeed(new ProfileDecoratorFromTemplate(), new AdDecorator(), $profile);
        }

        if (SearchMode::Private->name === $searchMode->name && $profile->isSubscription()) {
            return new PrivateTemplateFeed(new ProfileDecoratorFromTemplate(), new AdDecorator(), $profile);
        }

        throw new \Exception('Template feed is not supported');
    }
}
