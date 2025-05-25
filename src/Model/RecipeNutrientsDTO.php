<?php
namespace App\Model;

class RecipeNutrientsDTO
{
    public function __construct(
        public int $idNutrientType,//este id corresponde a una instancia de NutrientTypeDTO
        public NutrientTypeDTO $nutrientType,//este id corresponde a una instancia de NutrientTypeDTO
        public ?float $quantity = null,
    ){}
}
