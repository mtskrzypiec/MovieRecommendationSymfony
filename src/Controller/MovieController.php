<?php

declare(strict_types=1);

namespace App\Controller;

use MovieRecommendation\Enum\MovieRecommendationType;
use MovieRecommendation\Exceptions\StrategyWasNotRegistered;
use MovieRecommendation\MovieRecommender;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MovieController extends AbstractController
{
    public function __construct(
        #[Autowire(service: MovieRecommender::class)]
        private readonly MovieRecommender $movieRecommender
    ) {
    }

    #[Route('/movies/recommendations/{recommendationType}', name: 'app_movie', methods: ['GET'])]
    public function getRecommendations(string $recommendationType): JsonResponse
    {
        $type = MovieRecommendationType::tryFrom($recommendationType);

        if (is_null($type)) {
            return $this->json(
                [
                    "error" => sprintf(
                        "Invalid recommendation type '%s'. Available options: %s",
                        $recommendationType,
                        implode(', ', array_map(fn($case) => $case->value, MovieRecommendationType::cases()))
                    )
                ],
                Response::HTTP_BAD_REQUEST,
            );
        }

        try {
            return $this->json(
                ['recommendations' => $this->movieRecommender->getRecommendations($type)],
            );
        } catch (StrategyWasNotRegistered $e) {
            return $this->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
