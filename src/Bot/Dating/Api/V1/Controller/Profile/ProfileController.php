<?php

declare(strict_types=1);

namespace App\Bot\Dating\Api\V1\Controller\Profile;

use App\Bot\Dating\Modules\Profile\Dto\CreateProfileDto;
use App\Bot\Dating\Modules\Profile\Requests\CreateProfileRequest;
use App\Bot\Dating\Modules\Profile\Services\CreateProfileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/profile")
 */
class ProfileController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private CreateProfileService $createProfileService
    ) {
    }

    /**
     * @Route("/create", methods={"POST"})
     */
    public function create(CreateProfileRequest $request): JsonResponse
    {
        $dto = (new CreateProfileDto())->fillFromBaseRequest($request);
        $newProfile = $this->createProfileService->make($dto);

        return JsonResponse::fromJsonString(
            $this->serializer->serialize($newProfile, 'json')
        );
    }

    /**
     * @Route("/{id}", methods={"GET"})
     */
    public function read(Request $request): JsonResponse
    {
        return JsonResponse::fromJsonString(
            $this->serializer->serialize(['profile' => 46], 'json')
        );
    }

    /**
     * @Route("/{id}", methods={"PATCH"})
     */
    public function update(Request $request): JsonResponse
    {
        return JsonResponse::fromJsonString(
            $this->serializer->serialize(['profile' => 46], 'json')
        );
    }

    /**
     * @Route("/{id}", methods={"DELETE"})
     */
    public function delete(Request $request): JsonResponse
    {
        return JsonResponse::fromJsonString(
            $this->serializer->serialize(['profile' => 46], 'json')
        );
    }
}
