<?php
namespace App\Model;

use App\Model\RatingDTO;

class RecipeDTO
{
    public function __construct(
        public int $id,
        public string $title,
        public ?int $numberDinner = null,
        
        /** @var IngredientNewDTO[] */
        public array $ingredients,//de tipo IngredientNewDTO[]

        /** @var StepNewDTO[] */
        public array $steps,//de tipo StepNewDTO[]

        // /** @var NutrientTypeDTO[] */
        // public array $nutrients,//de tipo NutrientTypeDTO[]

        /** @var RecipeNutrientsDTO[] */
        public array $nutrients,//de tipo RecipeNutrientsDTO[]

        public RatingDTO $rating
    ){}
       
}
