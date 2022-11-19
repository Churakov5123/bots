<?php

declare(strict_types=1);

namespace App\Bot\Dating\Api\V1\Controller\Profile;

use App\Bot\Dating\Data\Entity\Profile;
use App\Bot\Dating\Modules\AffiliateProgram\Services\AffiliateProgramService;
use App\Bot\Dating\Modules\Profile\Decorator\ProfileDecorator;
use App\Bot\Dating\Modules\Profile\Dto\CreateProfileDto;
use App\Bot\Dating\Modules\Profile\Dto\ProfileDto;
use App\Bot\Dating\Modules\Profile\Requests\CreateProfileRequest;
use App\Bot\Dating\Modules\Profile\Requests\ProfileRequest;
use App\Bot\Dating\Modules\Profile\Services\ProfileService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/profile")
 */
class ProfileController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private ProfileService $profileService,
        private AffiliateProgramService $affiliateProgramService,
        private ProfileDecorator $profileDecorator
    ) {
    }

    /**
     * @Route("/create/{affiliateCode}", methods={"POST"})
     */
    public function create(CreateProfileRequest $request, ?string $affiliateCode = null): JsonResponse
    {
        $dto = (new CreateProfileDto())->fillFromBaseRequest($request);

        if (null !== $affiliateCode) {
            $this->affiliateProgramService->activateSubscriptionForAttracting($affiliateCode);
        }

        try {
            $result = $this->profileService->make($dto);
            $profile = $this->profileDecorator->presentProfile($result);

            return JsonResponse::fromJsonString(
                $this->serializer->serialize($profile, 'json'),
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
    public function read(?string $id = null): JsonResponse
    {
        try {
            if (null === $id) {
                throw new Exception('Profile not found', 404);
            }

            $result = $this->profileService->read($id);
            /** @var Profile $profile */
            $profile = $this->profileService->addLastActivity($result);

            return JsonResponse::fromJsonString(
                $this->serializer->serialize($this->profileDecorator->presentProfile($profile), 'json'),
            );
        } catch (\Exception $e) {
            return JsonResponse::fromJsonString(
                $this->serializer->serialize($e->getMessage(), 'json'),
                $e->getCode()
            );
        }
    }

    /**
     * @Route("/{id}", methods={"PATCH"})
     */
    public function update(ProfileRequest $request, ?string $id = null): JsonResponse
    {
        try {
            if (null === $id) {
                throw new Exception('Profile not found', 404);
            }
            /** @var Profile $profile */
            $profile = $this->profileService->read($id);

            $dto = (new ProfileDto())->fillFromBaseRequest($request);

            $result = $this->profileService->update($profile, $dto);
            $profile = $this->profileDecorator->presentProfile($result);

            return JsonResponse::fromJsonString(
                $this->serializer->serialize($profile, 'json'),
            );
        } catch (\Exception $e) {
            return JsonResponse::fromJsonString(
                $this->serializer->serialize($e->getMessage(), 'json'),
                $e->getCode()
            );
        }
    }

    /**
     * @Route("/deactivate/{id}", methods={"PATCH"})
     */
    public function deactivate(?string $id = null): JsonResponse
    {
        try {
            if (null === $id) {
                throw new Exception('Profile not found', 404);
            }

            $this->profileService->deactivate($id);

            $result = 'Profile deactivated successfully';

            return JsonResponse::fromJsonString(
                $this->serializer->serialize($result, 'json'),
            );
        } catch (\Exception $e) {
            return JsonResponse::fromJsonString(
                $this->serializer->serialize($e->getMessage(), 'json'),
                $e->getCode()
            );
        }
    }

    /**
     * @Route("/activate/{id}", methods={"PATCH"})
     */
    public function activate(?string $id = null): JsonResponse
    {
        try {
            if (null === $id) {
                throw new Exception('Profile not found', 404);
            }

            $this->profileService->activate($id);

            $result = 'Profile activated successfully';

            return JsonResponse::fromJsonString(
                $this->serializer->serialize($result, 'json'),
            );
        } catch (\Exception $e) {
            return JsonResponse::fromJsonString(
                $this->serializer->serialize($e->getMessage(), 'json'),
                $e->getCode()
            );
        }
    }

    /**
     * @Route("/{id}", methods={"DELETE"})
     */
    public function delete(?string $id = null): JsonResponse
    {
        try {
            if (null === $id) {
                throw new Exception('Profile not found', 404);
            }

            $this->profileService->delete($id);

            $result = 'Profile delete successfully';

            return JsonResponse::fromJsonString(
                $this->serializer->serialize($result, 'json'),
            );
        } catch (\Exception $e) {
            return JsonResponse::fromJsonString(
                $this->serializer->serialize($e->getMessage(), 'json'),
                $e->getCode()
            );
        }
    }

    /**
     * @Route("/who-like-you/{id}", methods={"GET"})
     */
    public function listWhoLikesYou(?string $id = null): JsonResponse
    {
        try {
            $profile = $this->read($id);
            // запрос на получиние данных

            return JsonResponse::fromJsonString(
                $this->serializer->serialize($profile, 'json'),
            );
        } catch (\Exception $e) {
            return JsonResponse::fromJsonString(
                $this->serializer->serialize($e->getMessage(), 'json'),
                $e->getCode()
            );
        }
    }

    /**
     * @Route("/who-you-like/{id}", methods={"GET"})
     */
    public function listWhoYouLke(?string $id = null): JsonResponse
    {
        try {
            $profile = $this->read($id);

            // запрос на получиние данных

            return JsonResponse::fromJsonString(
                $this->serializer->serialize($profile, 'json'),
            );
        } catch (\Exception $e) {
            return JsonResponse::fromJsonString(
                $this->serializer->serialize($e->getMessage(), 'json'),
                $e->getCode()
            );
        }
    }
}
