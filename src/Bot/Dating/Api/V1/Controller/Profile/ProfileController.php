<?php

declare(strict_types=1);

namespace App\Bot\Dating\Api\V1\Controller\Profile;

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
    private SerializerInterface $serializer;

    public function __construct(
        SerializerInterface $serializer,
    ) {
        $this->serializer = $serializer;
    }

    /**
     * @Route("/", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        return JsonResponse::fromJsonString(
            $this->serializer->serialize(['profile' => 46], 'json')
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
