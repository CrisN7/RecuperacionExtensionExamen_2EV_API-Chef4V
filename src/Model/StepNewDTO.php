<?php
namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class StepNewDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('int')]
        public ?int $order,//antes orderNumber, tuve que cambiar por postman 500 error

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public ?string $description
    ){}
       
}
