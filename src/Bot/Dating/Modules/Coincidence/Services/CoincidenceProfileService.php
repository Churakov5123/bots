<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Coincidence\Services;

use App\Bot\Dating\Data\Entity\Profile;
use App\Bot\Dating\Modules\Feed\Factory\TemplateFactory;
use App\Bot\Dating\Modules\Profile\Enum\SearchMode;

class CoincidenceProfileService
{
    public function __construct(
        private TemplateFactory $templateFactory,
    ) {
    }

    public function getPreparedMatch(Profile $profileOwner, Profile $matchProfile): array
    {
        $params = $profileOwner->toArray();
        $searchMode = SearchMode::from($params['searchMode']);
        $template = $this->templateFactory->getTemplate($searchMode, $profileOwner);

        return $template->prepareCoincidenceProfile($matchProfile);
    }
}
