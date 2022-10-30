<?php

declare(strict_types=1);

namespace App\Bot\Dating\Api\V1\Controller\Feed;

use App\Bot\Dating\Modules\Feed\Services\FeedService;
use App\Bot\Dating\Modules\Profile\Services\ProfileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
            dd($result);

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
     * @Route("/{id}", methods={"GET"})
     */
    public function read(Request $request): JsonResponse
    {
        return JsonResponse::fromJsonString(
            $this->serializer->serialize(['feed' => 43], 'json')
        );
    }
}
