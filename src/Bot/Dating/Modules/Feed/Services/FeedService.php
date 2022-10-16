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
    private const ADVERTISING_PLACE = 5;

    public function __construct(
        private ProfileRepository $profileRepository,
        private TemplateFactory $templateFactory,
    ) {
    }

    // логика на создание общей ленты с кешем  счетчиком и его обновлением
    public function getFeed(array $params, Profile $profile, int $limit): array
    {
        $searchMode = SearchMode::from($params['searchMode']);
        $template = $this->templateFactory->getTemplate($searchMode, $profile);

        return $this->getDataForFeed($params, $limit, $template);
    }

    private function getDataForFeed(array $params, int $limit, FeedTemplate $template): array
    {
//        dump($params);
//         $filtredParams =   $this->filteredParamsByProfile($params);
        // сырой запрос на получение профилей в зависимости от параметров и установленного лимита выборки
        $data = $this->profileRepository->getListByParams($params, $limit);
        // dd($data);
        return $this->prepareData($data, $template);
    }

    private function prepareData(array $profiles, FeedTemplate $template): array
    {
        $count = 0;
        $advertCount = 0;
        $result = [];

        foreach ($profiles as $profile) {
            ++$count;

            $result[] = $profile;

            if (self::ADVERTISING_PLACE === $count) {
                $ads = $advertCount >= $template->getAdvertCount() ? $advertCount = 0 : $advertCount++;

                $result[] = $template->getAdvert($ads);

                $count = 0;
            }
        }

        return $result;
    }
}
