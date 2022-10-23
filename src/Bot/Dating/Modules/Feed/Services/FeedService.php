<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Feed\Services;

use App\Bot\Dating\Data\Entity\Profile;
use App\Bot\Dating\Modules\Feed\Factory\TemplateFactory;
use App\Bot\Dating\Modules\Feed\Templates\FeedTemplate;
use App\Bot\Dating\Modules\Profile\Enum\SearchMode;
use App\Bot\Dating\Modules\Profile\Repository\ProfileRepository;

class FeedService
{
    public function __construct(
        private ProfileRepository $profileRepository,
        private TemplateFactory $templateFactory,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function getFeed(array $params, Profile $profile, int $limit): array
    {
        $searchMode = SearchMode::from($params['searchMode']);
        $template = $this->templateFactory->getTemplate($searchMode, $profile);

        return $this->getDataForFeed($params, $limit, $template);
    }

    private function getDataForFeed(array $params, int $limit, FeedTemplate $template): array
    {
        $data = $this->profileRepository->getListByParams($params, $limit);

        return $template->prepareData($data);
    }
}
