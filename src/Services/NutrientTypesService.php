<?php
namespace App\Services;

use App\Model\NutrientTypeDTO;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

use App\Entity\NutrientType;

class NutrientTypesService
{

    public function __construct(private LoggerInterface $logger, private EntityManagerInterface $entityManager)
    {

        //Cargamos tipos de nutrientes si no hay ninguno
        if (sizeof($this->getAllNutrientTypes()) < 1) {
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

    public function getAllNutrientTypes(): array
    {
        $nutrientTypes = $this->entityManager->getRepository(NutrientType::class)->findAll();

        if (empty($nutrientTypes)) {
            $this->logger->warning('No hay tipos de nutrientes.');
            return [];
        }
        
        return array_map(function (NutrientType $nutrientType) {
            return new NutrientTypeDTO(
                id: $nutrientType->getId(),
                name: $nutrientType->getName(),
                unit: $nutrientType->getUnit()
            );
        }, $nutrientTypes);
    }

}
?>