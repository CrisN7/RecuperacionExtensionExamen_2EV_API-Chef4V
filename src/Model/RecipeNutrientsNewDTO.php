<?php
namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class RecipeNutrientsNewDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public int $idNutrientType,//este id corresponde a una instancia de NutrientTypeNewDTO

        #[Assert\NotBlank]
        #[Assert\Type('float')]
        public ?float $quantity = null,
    ){}
       
}
