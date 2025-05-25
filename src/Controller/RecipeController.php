<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

use App\Services\RecipeService;

final class RecipeController extends AbstractController
{

    public function __construct(private RecipeService $servicioRestaurantes){
    }

    #[Route('/nutrient/type', name: 'app_nutrient_type')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/NutrientTypeController.php',
        ]);
    }
    
}

