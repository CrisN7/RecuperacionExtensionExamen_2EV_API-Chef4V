<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?string $title = null;

    #[ORM\Column]
    private ?int $numberDinner = null;

    /**
     * @var Collection<int, Ingredient>
     */
    #[ORM\OneToMany(targetEntity: Ingredient::class, mappedBy: 'recipe', cascade: ['persist'])]
    private Collection $ingredients;

    /**
     * @var Collection<int, Step>
     */
    #[ORM\OneToMany(targetEntity: Step::class, mappedBy: 'recipe', cascade: ['persist'])]
    private Collection $steps;

    /**
     * @var Collection<int, Rating>
     */
    #[ORM\OneToMany(targetEntity: Rating::class, mappedBy: 'recipe', cascade: ['persist'])]
    private Collection $rating;

    /**
     * @var Collection<int, RecipesNutrients>
     */
    #[ORM\OneToMany(targetEntity: RecipesNutrients::class, mappedBy: 'recipe', cascade: ['persist'])]
    private Collection $nutrients;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
        $this->steps = new ArrayCollection();
        $this->rating = new ArrayCollection();
        $this->nutrients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getNumberDinner(): ?int
    {
        return $this->numberDinner;
    }

    public function setNumberDinner(int $numberDinner): static
    {
        $this->numberDinner = $numberDinner;

        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): static
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
            $ingredient->setRecipe($this);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): static
    {
        if ($this->ingredients->removeElement($ingredient)) {
            // set the owning side to null (unless already changed)
            if ($ingredient->getRecipe() === $this) {
                $ingredient->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Step>
     */
    public function getSteps(): Collection
    {
        return $this->steps;
    }

    public function addStep(Step $step): static
    {
        if (!$this->steps->contains($step)) {
            $this->steps->add($step);
            $step->setRecipe($this);
        }

        return $this;
    }

    public function removeStep(Step $step): static
    {
        if ($this->steps->removeElement($step)) {
            // set the owning side to null (unless already changed)
            if ($step->getRecipe() === $this) {
                $step->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Rating>
     */
    public function getRating(): Collection
    {
        return $this->rating;
    }

    public function addRating(Rating $rating): static
    {
        if (!$this->rating->contains($rating)) {
            $this->rating->add($rating);
            $rating->setRecipe($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): static
    {
        if ($this->rating->removeElement($rating)) {
            // set the owning side to null (unless already changed)
            if ($rating->getRecipe() === $this) {
                $rating->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RecipesNutrients>
     */
    public function getNutrients(): Collection
    {
        return $this->nutrients;
    }

    public function addNutrient(RecipesNutrients $nutrient): static
    {
        if (!$this->nutrients->contains($nutrient)) {
            $this->nutrients->add($nutrient);
            $nutrient->setRecipe($this);
        }

        return $this;
    }

    public function removeNutrient(RecipesNutrients $nutrient): static
    {
        if ($this->nutrients->removeElement($nutrient)) {
            // set the owning side to null (unless already changed)
            if ($nutrient->getRecipe() === $this) {
                $nutrient->setRecipe(null);
            }
        }

        return $this;
    }
}
