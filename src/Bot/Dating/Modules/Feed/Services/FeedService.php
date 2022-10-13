<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Feed\Services;

use App\Bot\Dating\Modules\Feed\Templates\FeedTemplate;
use App\Bot\Dating\Modules\Image\Services\ImageHandler;
use App\Bot\Dating\Modules\Profile\Enum\SearchMode;
use App\Bot\Dating\Modules\Profile\Repository\ProfileRepository;

class FeedService
{
    private const ADVERTISING_PLACE = 4;

    public function __construct(
        private ProfileRepository $profileRepository,
        private ImageHandler $imageHandler,
        private TemplateFactory $templateFactory,
    ) {
    }

    public function getFeed(array $params): array
    {
        // логика на создание общей ленты с кешем  счетчиком и его обновлением
        $limit = 100;

        // В зависимости от того какой вид поиска выбрал человек мы будем формировать шаблон ленты выдачи
        $searchMode = SearchMode::from($params['searchMode']);
        $template = $this->templateFactory->getTemplate($searchMode);

        $feed = $this->getDataForFeed($params, $limit, $template);
    }

    private function getDataForFeed(array $params, int $limit, FeedTemplate $template): array
    {
        // сырой запрос на получение профилей в зависимости от параметров и установленного лимита выборки
        $data = $this->profileRepository->getListByParams($params, $limit);

        return $this->prepareData($data, $template);
    }

    private function prepareData(array $profiles, FeedTemplate $template): array
    {
        $count = 0;
        $result = [];

        foreach ($profiles as $profile) {
            ++$count;

            $result[] = $profile;

            if ($count >= self::ADVERTISING_PLACE) {
            }
        }

        return $result;
    }
}
