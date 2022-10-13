<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Feed\Services;

use App\Bot\Dating\Modules\Feed\Templates\BaseTemplateFeed;
use App\Bot\Dating\Modules\Feed\Templates\FeedTemplate;
use App\Bot\Dating\Modules\Feed\Templates\PrivateTemplateFeed;
use App\Bot\Dating\Modules\Profile\Enum\SearchMode;

class TemplateFactory
{
    public function getTemplate(SearchMode $searchMode): FeedTemplate
    {
        if (SearchMode::Base->name === $searchMode->name) {
            return new BaseTemplateFeed();
        }

        if (SearchMode::Private->name === $searchMode->name) {
            return new PrivateTemplateFeed();
        }

        throw new \Exception('Template feed is not supported');
    }
}
