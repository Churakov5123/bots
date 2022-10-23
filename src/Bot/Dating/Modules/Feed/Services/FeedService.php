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
        // В зависимости от того какой шаблон - такой заранее будет запрос в базу данных - с филтрацией на пол и интерс приватоного, и все остальное для базового!
        // режим не будет учитываться в заапросе - только тип анкеты если это привтный (  поиск ) !
        $data = $this->profileRepository->getListByParams($params, $limit);

        return $template->prepareData($data);
    }
}
