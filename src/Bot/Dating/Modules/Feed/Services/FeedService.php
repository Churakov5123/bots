<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Feed\Services;

use App\Bot\Dating\Modules\Image\Services\ImageHandler;
use App\Bot\Dating\Modules\Profile\Repository\ProfileRepository;

class FeedService
{
    public function __construct(
        private ProfileRepository $profileRepository,
        private ImageHandler $imageHandler,
    ) {
    }

    public function getFeed(array $params): array
    {
        // логика на создание общей ленты с кешем  счетчиком и его обновлением
        $limit = 100;

        $feed = $this->getDataForFeed($params, $limit);
    }

    private function getDataForFeed(array $params, int $limit): array
    {
        // сырой запрос на получение профилей в зависимости от параметров и установленного лимита выборки
        $data = $this->profileRepository->getListByParams($params, $limit);

        return $this->prepareData($data);
    }

    private function prepareData(array $profiles): array
    {
        // логика на создание ленты
        return [];
    }
}
