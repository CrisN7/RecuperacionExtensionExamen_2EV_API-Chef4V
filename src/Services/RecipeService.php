<?php
namespace App\Services;

use App\Model\RecipeNewDTO;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use App\Entity\Recipe;
use App\Entity\Ingredient;
use App\Entity\Step;
use App\Entity\RecipesNutrients;
use App\Entity\NutrientType;

class RecipeService
{

    public function __construct(private LoggerInterface $logger, private EntityManagerInterface $entityManager)
    {}


    public function createRecipe(RecipeNewDTO $recipeNewDTO): RecipeNewDTO//CRIS: segun el enunciado: porque en el enunciado dice: Si todo es correcto se devuelve la información entera de la receta introducida. 
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

}
?>