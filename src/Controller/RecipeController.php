<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpFoundation\Response;
use App\Model\RecipeNewDTO;
use Psr\Log\LoggerInterface;

use App\Services\RecipeService;

final class RecipeController extends AbstractController
{

    public function __construct(private LoggerInterface $logger, private RecipeService $recipeService){
    }

    #[Route('/recipes', name: 'app_recipe', methods: ['GET'], format: 'json')]
    public function getAllRecipesc(): JsonResponse
    {
        $recipes = $this->recipeService->getAllRecipes();

        if (empty($recipes)) {
            return $this->json([
                'message' => 'No se encontraron recetas.',
            ], Response::HTTP_NOT_FOUND);
        }

        return $this->json($recipes, Response::HTTP_OK);
    }

    
    #[Route('/recipes', name: 'app_recipe_create', methods: ['POST'], format: 'json')]
    public function createRecipe(#[MapRequestPayload(validationFailedStatusCode: Response::HTTP_NOT_FOUND)] RecipeNewDTO $recipeNewDTO): JsonResponse //MapRequestPayload, indica que hay que utilizar un objeto RecipeNewDTO a mapear 
    {
        $this->logger->info("Me  has pasado como parametro: " . json_encode($recipeNewDTO));

        $isRecipeCreated = $this->recipeService->createRecipe($recipeNewDTO);
        $this->logger->info("isRecipeCreated: " . json_encode($isRecipeCreated));

        if (!$isRecipeCreated) {
            return $this->json([
                'message' => 'Error creating recipe',
            ], Response::HTTP_BAD_REQUEST);
        }

        return $this->json($isRecipeCreated, Response::HTTP_CREATED); //CRIS: segun el enunciado: Si todo es correcto se devuelve la información entera de la receta introducida.
    }


    #[Route('/recipes/{recipeId}/rating/{rate}', name: 'app_recipe_vote', methods: ['POST'], format: 'json')]
    public function voteRecipe(int $recipeId, int $rate): JsonResponse 
    {
        if ($this->recipeService->existsRecipeById($recipeId)){

            if ($rate < 1 || $rate > 5) {
                return $this->json(['error' => 'El voto debe ser un número entero entre 1 y 5 inclusives'], 400);
            }

            return $this->json($this->recipeService->voteRecipe($recipeId, $rate), Response::HTTP_OK);
        }
        else {
            return $this->json(["error" => "No existe una receta con ID: " . $recipeId], 400);
        }
    }
    
}

