<?php
namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class RecipeService
{

    public function __construct(private LoggerInterface $logger, private EntityManagerInterface $entityManager)
    {}


}
?>