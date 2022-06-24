<?php

declare(strict_types=1);

namespace App\Bot\Dating\Api\V1\Controller\Statistic;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/Statistic")
 */
class StatisticController extends AbstractController
{
    private SerializerInterface $serializer;

    public function __construct(
        SerializerInterface $serializer,
    ) {
        $this->serializer = $serializer;
    }

    /**
     * @Route("/", methods={"GET"})
     */
    public function list(Request $request): JsonResponse
    {
        return JsonResponse::fromJsonString(
            $this->serializer->serialize(['statistic' => 45], 'json')
        );
    }

    /**
     * @Route("/{id}", methods={"GET"})
     */
    public function read(Request $request): JsonResponse
    {
        return JsonResponse::fromJsonString(
            $this->serializer->serialize(['statistic' => 45], 'json')
        );
    }
}
