<?php

namespace App\Model;

//Primero tenemos que meter el paquete de validadores con composer: composer require symfony/validator
use Symfony\Component\Validator\Constraints as Assert;//Esta línea importa las restricciones de validación (constraints) del componente de validación de Symfony, pero le asigna un alias para simplificar su uso.
/*
Symfony\Component\Validator\Constraints: Es el espacio de nombres donde Symfony agrupa todas las restricciones de validación, como NotBlank, Length, Email, etc.
as Assert: Es un alias que te permite usar un prefijo más corto (Assert) en lugar de escribir el nombre completo del espacio de nombres cada vez que necesitas una validación.*/

//Este DTO (Data Transfer Object) se utiliza para transferir datos de un restaurante nuevo, incluyendo su ID, nombre y tipo de restaurante.
class RecipeNewDTO
{
    public function __construct(
        // #[Assert\NotBlank]//No puede ser null. No puede ser una cadena vacía (""). No puede ser solo espacios en blanco.
        // public int $id,
        #[Assert\NotBlank(message:"El título es obligatorio")]
        public string $title,
        #[Assert\NotBlank(message: "El número de comensales es obligatorio")]
        #[Assert\Positive(message: "El número de comensales debe ser mayor que 0")]
        public ?int $numberDinner = null,
        
        /** @var IngredientNewDTO[] */
        #[Assert\Count(
            min: 1,
            minMessage: "Debe incluir al menos un ingrediente"
        )]
        #[Assert\Valid] //Para validar los ingredientes, pasos y nutrientes
        public array $ingredients,//de tipo IngredientNewDTO[]

        /** @var StepNewDTO[] */
        #[Assert\Count(
            min: 1,
            minMessage: "Debe incluir al menos un paso"
        )]
        #[Assert\Valid] 
        public array $steps,//de tipo StepNewDTO[]

        /** @var RecipeNutrientsNewDTO[] */
        // #[Assert\Count(
        //     min: 1,
        //     minMessage: "Debe incluir al menos un ingrediente"
        // )]
        #[Assert\Valid] 
        public array $nutrients//de tipo RecipeNutrientsNewDTO[]
    ){}
       
}
