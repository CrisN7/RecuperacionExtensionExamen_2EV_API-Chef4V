<?php
namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class NutrientTypeNewDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public ?string $name = null,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public ?string $unit = null
    ){}
       
}
