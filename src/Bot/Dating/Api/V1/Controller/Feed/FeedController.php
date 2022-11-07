<?php

declare(strict_types=1);

namespace App\Bot\Dating\Api\V1\Controller\Feed;

use App\Bot\Dating\Modules\Feed\Dto\ReadFeedDto;
use App\Bot\Dating\Modules\Feed\Requests\ReadFeedRequest;
use App\Bot\Dating\Modules\Feed\Services\FeedService;
use App\Bot\Dating\Modules\Profile\Services\ProfileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

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
            $profile = $this->profileService->read($profileId);

            if (!$profile->isActive()) {
                throw new \Exception('Сперва активируйте Ваш профиль в настройках, после вам будет доступен режим поиска.');
            }

            $result = $this->feedService->getFeed($profile->toArray(), $profile);

            return JsonResponse::fromJsonString(
                $this->serializer->serialize($result, 'json'),
            );
        } catch (\Exception $e) {
            return JsonResponse::fromJsonString(
                $this->serializer->serialize(['error' => $e->getMessage()], 'json'),
                $e->getCode()
            );
        }
    }

    /**
     * @Route("/{id}", methods={"POST"})
     */
    public function read(ReadFeedRequest $request, ?string $profileId = null): JsonResponse
    {
        try {
            $profile = $this->profileService->read($profileId);

            if (!$profile->isActive()) {
                throw new \Exception('Сперва активируйте Ваш профиль в настройках, после вам будет доступен режим поиска.');
            }

            if (null === get_cache('count')) {
                set_cache('count', 0, '1d');
            }
            // поставить в кэш!
            if (null === get_cache('feeds')) {
                set_cache('feeds', $this->feedService->getFeed($profile->toArray(), $profile), '1d');
            }

            $feed = get_cache('feeds')[get_cache('count')];

            /** @var ReadFeedDto $dto */
            $dto = (new ReadFeedDto())->fillFromBaseRequest($request);
            if (null !== $dto->getProfileId() && null !== $dto->getResolution()) {
                // тут будет подключена система логирования решения по каждому  подльзователю из фида
            }

            set_cache('count', +1, '1d');

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
}
