<?php

declare(strict_types=1);

namespace App\Bot\Dating\Api\V1\Controller\Statistic;

use App\Bot\Dating\Modules\Statistic\Services\StatisticService;
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
    public function __construct(
       private SerializerInterface $serializer,
       private StatisticService $statisticService
    ) {
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
}
