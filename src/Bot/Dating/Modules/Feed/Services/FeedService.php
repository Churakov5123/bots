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
        private TemplateFactory $templateFactory,
        private ProfileRepository $profileRepository
    ) {
    }

    /**
     * @throws \Exception
     */
    public function getFeed(array $params, Profile $profile): array
    {
        $searchMode = SearchMode::from($params['searchMode']);
        $template = $this->templateFactory->getTemplate($searchMode, $profile);

        return $this->getDataForFeed($params, $template);
    }

    private function getDataForFeed(array $params, FeedTemplate $template): array
    {
        // В зависимости от того какой шаблон - такой заранее будет запрос в базу данных - с филтрацией на пол и интерс приватоного, и все остальное для базового!
        // режим не будет учитываться в заапросе - только тип анкеты если это привтный (  поиск ) !
        $data = $this->getDataForTemplate($template, $params);

        return $template->prepareData($data);
    }

    private function getDataForTemplate(FeedTemplate $template, array $params): array
    {
        if ($template->isBaseTemplate()) {
            return $this->profileRepository->getListForBaseTemplate($params);
        }

        if ($template->isPrivateTemplate()) {
            return $this->profileRepository->getListForPrivateTemplate($params);
        }

        throw new \Exception('Template feed is not supported');
    }
}
