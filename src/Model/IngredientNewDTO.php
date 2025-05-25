<?php
namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class IngredientNewDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public ?string $name = null,

        #[Assert\NotBlank]
        #[Assert\Type('float')]
        public ?float $quantity = null,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public ?string $unit = null
    ){}
       
}
