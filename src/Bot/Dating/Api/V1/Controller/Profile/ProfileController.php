<?php

declare(strict_types=1);

namespace App\Bot\Dating\Api\V1\Controller\Profile;

use App\Bot\Dating\Modules\Profile\Dto\CreateProfileDto;
use App\Bot\Dating\Modules\Profile\Dto\ProfileDto;
use App\Bot\Dating\Modules\Profile\Dto\ReadProfileDto;
use App\Bot\Dating\Modules\Profile\Requests\CreateProfileRequest;
use App\Bot\Dating\Modules\Profile\Requests\ProfileRequest;
use App\Bot\Dating\Modules\Profile\Requests\ReadProfileRequest;
use App\Bot\Dating\Modules\Profile\Services\ProfileService;
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
        private ProfileService $profileService
    ) {
    }

    /**
     * @Route("/create", methods={"POST"})
     */
    public function create(CreateProfileRequest $request): JsonResponse
    {
        $dto = (new CreateProfileDto())->fillFromBaseRequest($request);

        try {
            $result = $this->profileService->make($dto);

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
     * @Route("/{id}", methods={"GET"})
     */
    public function read(ReadProfileRequest $request): JsonResponse
    {
        $dto = (new ReadProfileDto())->fillFromBaseRequest($request);

        try {
            $result = $this->profileService->read($dto->getId());

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
     * @Route("/{id}", methods={"PATCH"})
     */
    public function update(ProfileRequest $request): JsonResponse
    {
        $dto = (new ProfileDto())->fillFromBaseRequest($request);

        try {
            $result = $this->profileService->update($dto);

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
    public function delete(ReadProfileRequest $request): JsonResponse
    {
        $dto = (new ReadProfileDto())->fillFromBaseRequest($request);

        try {
            $this->profileService->delete($dto->getId());

            $result = 'Profile deleted successfully';

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
}
