<?php
namespace App\Services;

use App\Model\RecipeNewDTO;
use App\Model\RecipeDTO;
use App\Model\IngredientNewDTO;
use App\Model\StepNewDTO;
use App\Model\RecipeNutrientsDTO;
use App\Model\NutrientTypeDTO;
use App\Model\RatingDTO;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

use App\Entity\Recipe;
use App\Entity\Ingredient;
use App\Entity\Step;
use App\Entity\RecipesNutrients;
use App\Entity\NutrientType;
use App\Entity\Rating;
use App\Services\NutrientTypesService;

class RecipeService
{

    public function __construct(private LoggerInterface $logger, private EntityManagerInterface $entityManager, private NutrientTypesService $nutrientTypesService)
    {

        //Cargamos tipos de nutrientes si no existen
        if (sizeof($this->nutrientTypesService->getAllNutrientTypes()) < 1) {
            $nutrientTypes = [];

            $newNutrientType = new NutrientType();
            $newNutrientType->setName('Proteínas');
            $newNutrientType->setUnit('gr');
            $nutrientTypes[] = $newNutrientType;

            $newNutrientType = new NutrientType();
            $newNutrientType->setName('Carbohidratos');
            $newNutrientType->setUnit('gr');
            $nutrientTypes[] = $newNutrientType;

            $newNutrientType = new NutrientType();
            $newNutrientType->setName('Grasas');
            $newNutrientType->setUnit('gr');
            $nutrientTypes[] = $newNutrientType;

            $newNutrientType = new NutrientType();
            $newNutrientType->setName('Fibra');
            $newNutrientType->setUnit('gr');
            $nutrientTypes[] = $newNutrientType;

            $newNutrientType = new NutrientType();
            $newNutrientType->setName('Calorías');
            $newNutrientType->setUnit('kcal');
            $nutrientTypes[] = $newNutrientType;

            $newNutrientType = new NutrientType();
            $newNutrientType->setName('Azúcares');
            $newNutrientType->setUnit('gr');
            $nutrientTypes[] = $newNutrientType;

            foreach ($nutrientTypes as $type) {
                $this->entityManager->persist($type);
            }

            $this->entityManager->flush();
        }

    }

    public function getAllRecipes(): array
    {
        $recipes = $this->entityManager->getRepository(Recipe::class)->findAll();
        
        return array_map(function (Recipe $recipe) {
            return new RecipeDTO(
                id: $recipe->getId(),
                title: $recipe->getTitle(),
                numberDinner: $recipe->getNumberDinner(),
                ingredients: array_map(fn ($ingredient) => new IngredientNewDTO(
                    name: $ingredient->getName(),
                    quantity: $ingredient->getQuantity(),
                    unit: $ingredient->getUnit()
                ), $recipe->getIngredients()->toArray()),
                steps: array_map(fn ($step) => new StepNewDTO(
                    order: $step->getOrderNumber(),
                    description: $step->getDescription()
                ), $recipe->getSteps()->toArray()),
                nutrients: array_map(fn ($recipeNutrient) => new RecipeNutrientsDTO(
                    idNutrientType: $recipeNutrient->getType()->getId(),
                    nutrientType: new NutrientTypeDTO(
                        id: $recipeNutrient->getType()->getId(),
                        name: $recipeNutrient->getType()->getName(),
                        unit: $recipeNutrient->getType()->getUnit()
                    ),
                    quantity: $recipeNutrient->getQuantity()
                ),
                $recipe->getNutrients()->toArray()),
                rating: new RatingDTO(
                    numberVotes: $recipe->getRating()->count(),
                    ratingAvg: $recipe->getRating()->count() > 0 ? 
                        array_reduce($recipe->getRating()->toArray(), fn ($carry, $rating) => $carry + $rating->getRatingAvg(), 0) / $recipe->getRating()->count() : 0
                )
            );
        }, $recipes);
    }


    public function createRecipe(RecipeNewDTO $recipeNewDTO): RecipeNewDTO
    {

        $recipe = new Recipe();
        $recipe->setTitle($recipeNewDTO->title);
        $recipe->setNumberDinner($recipeNewDTO->numberDinner);

        foreach ($recipeNewDTO->ingredients as $eachIngredientDto) {
            $ingredient = new Ingredient();
            $ingredient->setName($eachIngredientDto->name);
            $ingredient->setQuantity($eachIngredientDto->quantity);
            $ingredient->setUnit($eachIngredientDto->unit);
            $ingredient->setRecipe($recipe);
            $recipe->getIngredients()->add($ingredient);
        }

        foreach ($recipeNewDTO->steps as $eachStepDto) {
            $step = new Step();
            $step->setOrderNumber($eachStepDto->order);
            $step->setDescription($eachStepDto->description);
            $step->setRecipe($recipe);
            $recipe->getSteps()->add($step);
        }

        foreach ($recipeNewDTO->nutrients as $eachRecipeNutrientsDto) {
            $recipeNutrients = new RecipesNutrients();

            $nutrientType = $this->entityManager->getRepository(NutrientType::class)->find($eachRecipeNutrientsDto->idNutrientType);
            if (!$nutrientType) {
                throw new \Exception('El ID de idNutrientType que insertaste no esta dado de alta: ' . $eachRecipeNutrientsDto->idNutrientType);
            }

            $recipeNutrients->setType($nutrientType);
            $recipeNutrients->setQuantity($eachRecipeNutrientsDto->quantity);
            $recipeNutrients->setRecipe($recipe);
            $recipe->getNutrients()->add($recipeNutrients);
        }

        $this->entityManager->persist($recipe);
        $this->entityManager->flush();

        return $recipeNewDTO;
    }

    public function voteRecipe(int $recipeId, int $rate): bool
    {
        $recipe = $this->entityManager->getRepository(Recipe::class)->find($recipeId);

        //Obtenemos la colección de ratings existentes
        $ratings = $recipe->getRating();

        //Calculamos el total de votos y suma total de puntuaciones previas
        $totalVotes = $ratings->count();
        $sumRates = 0;

        foreach ($ratings as $r) {
            $sumRates += $r->getRatingAvg();
        }

        //Añadimos el nuevo voto
        $totalVotes += 1;
        $sumRates += $rate;

        $newAvg = $sumRates / $totalVotes;

        //Actualizamos todos los objetos Rating existentes
        foreach ($ratings as $r) {
            $r->setNumberVotes($totalVotes);
            $r->setRatingAvg($newAvg);
            $this->entityManager->persist($r);
        }

        $newRating = new Rating();
        $newRating->setNumberVotes($totalVotes);
        $newRating->setRatingAvg($newAvg);
        $newRating->setRecipe($recipe);
        $this->entityManager->persist($newRating);

        $this->entityManager->flush();

        return true;
    }


    public function existsRecipeById(int $recipeId): bool
    {
        $recipe = $this->entityManager->getRepository(Recipe::class)->find($recipeId);
        return $recipe !== null;
    }

}
?>