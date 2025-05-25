<?php

namespace App\Entity;

use App\Repository\RecipesNutrientsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipesNutrientsRepository::class)]
class RecipesNutrients
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'recipesNutrients')]
    private ?NutrientType $type = null;

    #[ORM\Column]
    private ?float $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'nutrients')]
    private ?Recipe $recipe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?NutrientType
    {
        return $this->type;
    }

    public function setType(?NutrientType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipe $recipe): static
    {
        $this->recipe = $recipe;

        return $this;
    }
}
