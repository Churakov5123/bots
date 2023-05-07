<?php

declare(strict_types=1);

namespace App\Bot\Dating\Modules\Feed\Services;

use App\Bot\Dating\Data\Entity\Profile;
use App\Bot\Dating\Modules\Coincidence\Dto\ReadFeedDto;
use App\Bot\Dating\Modules\Coincidence\Services\CoincidenceService;
use App\Bot\Dating\Modules\Feed\Exceptions\FeedLimitException;
use App\Bot\Dating\Modules\Feed\Factory\TemplateFactory;
use App\Bot\Dating\Modules\Feed\Templates\FeedTemplate;
use App\Bot\Dating\Modules\Profile\Enum\SearchMode;
use App\Bot\Dating\Modules\Profile\Services\ProfileService;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class FeedService
{
    public function __construct(
        private TemplateFactory $templateFactory,
        private ProfileService $profileService,
        private CoincidenceService $coincidenceService,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function getFeed(Profile $profile): array
    {
        $params = $profile->toArray();
        $searchMode = SearchMode::from($params['searchMode']);
        $template = $this->templateFactory->getTemplate($searchMode, $profile);

        return $this->getDataForFeed($params, $template);
    }

    /**
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws FeedLimitException
     */
    public function getSingleFeed(Profile $profile, CacheInterface $redisCache, ReadFeedDto $dto): array
    {
        $count = $redisCache->get(sprintf('%s_%s', 'count', $profile->getId()), function (ItemInterface $item): int {
            $item->expiresAfter(3600);

            return 0;
        });

        $feeds = $redisCache->get(sprintf('%s_%s', 'feeds', $profile->getId()), function (ItemInterface $item) use ($profile): array {
            $item->expiresAfter(3600);

            return $this->getFeed($profile);
        });

        if (count($feeds) < $count + 1) {
            $redisCache->delete(sprintf('%s_%s', 'count', $profile->getId()));
            $redisCache->delete(sprintf('%s_%s', 'feeds', $profile->getId()));

            throw new FeedLimitException();
        }

        $feed = $feeds[$count];
        $next = ++$count;

        $this->coincidenceService->makeCoincidenceActivity($profile, $dto);

        $redisCache->delete(sprintf('%s_%s', 'count', $profile->getId()));
        $redisCache->get(sprintf('%s_%s', 'count', $profile->getId()), function (ItemInterface $item) use ($next): int {
            $item->expiresAfter(3600);

            return $next;
        });

        return $feed;
    }

    /**
     * @throws \Exception
     */
    private function getDataForFeed(array $params, FeedTemplate $template): array
    {
        $data = $this->profileService->getDataForTemplate($template, $params);

        return $template->prepareProfiles($data);
    }
}
