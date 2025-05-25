<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Services\NutrientTypesService;
use Psr\Log\LoggerInterface;

final class NutrientTypeController extends AbstractController
{
    public function __construct(private LoggerInterface $logger, private NutrientTypesService $nutrientTypesService){
    }

    #[Route('/nutrient-types', name: 'app_nutrient_type', methods: ['GET'], format: 'json')]
    public function getAllNutrientTypes(): JsonResponse
    {
        $nutrientTypes = $this->nutrientTypesService->getAllNutrientTypes();

        if (empty($nutrientTypes)) {
            return $this->json([
                'message' => 'No se encontraron tipos de nutrientes.',
            ], Response::HTTP_NOT_FOUND);
        }

        return $this->json($nutrientTypes, Response::HTTP_OK);
    }
}
