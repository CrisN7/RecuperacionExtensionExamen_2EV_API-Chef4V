<?php
namespace App\Model;

class NutrientTypeDTO
{
    public function __construct(
        public int $id,
        public ?string $name = null,
        public ?string $unit = null
    ){}
       
}
