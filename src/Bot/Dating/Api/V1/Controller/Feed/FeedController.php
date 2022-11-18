<?php

declare(strict_types=1);

namespace App\Bot\Dating\Api\V1\Controller\Feed;

use App\Bot\Dating\Data\Entity\Profile;
use App\Bot\Dating\Modules\Coincidence\Dto\ReadFeedDto;
use App\Bot\Dating\Modules\Feed\Exceptions\FeedLimitException;
use App\Bot\Dating\Modules\Feed\Requests\ReadFeedRequest;
use App\Bot\Dating\Modules\Feed\Services\FeedService;
use App\Bot\Dating\Modules\Profile\Services\ProfileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Cache\CacheInterface;

/**
 * @Route("/feed")
 */
class FeedController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private FeedService $feedService,
        private ProfileService $profileService,
    ) {
    }

    /**
     * @Route("/{profileId}", methods={"GET"})
     */
    public function list(?string $profileId = null): JsonResponse
    {
        try {
            $result = $this->profileService->read($profileId);

            if (!$result->isActive()) {
                throw new \Exception('Сперва активируйте Ваш профиль в настройках, после вам будет доступен режим поиска.');
            }
            /** @var Profile $profile */
            $profile = $this->profileService->addLastActivity($result);
            $feed = $this->feedService->getFeed($profile);

            return JsonResponse::fromJsonString(
                $this->serializer->serialize($feed, 'json'),
            );
        } catch (\Exception $e) {
            return JsonResponse::fromJsonString(
                $this->serializer->serialize(['error' => $e->getMessage()], 'json'),
                $e->getCode()
            );
        }
    }

    /**
     * @Route("/{profileId}", methods={"POST"})
     */
    public function read(ReadFeedRequest $request, CacheInterface $redisCache, ?string $profileId = null): JsonResponse
    {
        try {
            $result = $this->profileService->read($profileId);

            if (!$result->isActive()) {
                throw new \Exception('Сперва активируйте Ваш профиль в настройках, после вам будет доступен режим поиска.');
            }
            /** @var Profile $profile */
            $profile = $this->profileService->addLastActivity($result);
            $dto = (new ReadFeedDto())->fillFromBaseRequest($request);

            $feed = $this->feedService->getSingleFeed($profile, $redisCache, $dto);

            return JsonResponse::fromJsonString(
                $this->serializer->serialize($feed, 'json'),
            );
        } catch (FeedLimitException $e) {
            return JsonResponse::fromJsonString(
                $this->serializer->serialize(['msg' => 'Лимит поиска исчерпан, начните с начала, возможно появится кто-то новенький )'],
                    'json'),
            );
        } catch (\Exception $e) {
            return JsonResponse::fromJsonString(
                $this->serializer->serialize(['error' => $e->getMessage()], 'json'),
                $e->getCode()
            );
        }
    }
}
