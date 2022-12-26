<?php

declare(strict_types=1);

namespace App\Bot\Dating\Api\V1\Controller\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/auth")
 */
class AuthController extends AbstractController
{
    private SerializerInterface $serializer;

    public function __construct(
        SerializerInterface $serializer,
    ) {
        $this->serializer = $serializer;
    }
}
