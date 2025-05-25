<?php
namespace App\Services;

use App\Model\NutrientTypeDTO;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

use App\Entity\NutrientType;

class NutrientTypesService
{

    public function __construct(private LoggerInterface $logger, private EntityManagerInterface $entityManager)
    {}

    public function getAllNutrientTypes(): array
    {
        $nutrientTypes = $this->entityManager->getRepository(NutrientType::class)->findAll();
        
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