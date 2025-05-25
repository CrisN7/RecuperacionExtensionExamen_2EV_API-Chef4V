<?php

namespace App\Entity;

use App\Repository\NutrientTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NutrientTypeRepository::class)]
class NutrientType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $unit = null;

    /**
     * @var Collection<int, RecipesNutrients>
     */
    #[ORM\OneToMany(targetEntity: RecipesNutrients::class, mappedBy: 'type')]
    private Collection $recipesNutrients;

    public function __construct()
    {
        $this->recipesNutrients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): static
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * @return Collection<int, RecipesNutrients>
     */
    public function getRecipesNutrients(): Collection
    {
        return $this->recipesNutrients;
    }

    public function addRecipesNutrient(RecipesNutrients $recipesNutrient): static
    {
        if (!$this->recipesNutrients->contains($recipesNutrient)) {
            $this->recipesNutrients->add($recipesNutrient);
            $recipesNutrient->setType($this);
        }

        return $this;
    }

    public function removeRecipesNutrient(RecipesNutrients $recipesNutrient): static
    {
        if ($this->recipesNutrients->removeElement($recipesNutrient)) {
            // set the owning side to null (unless already changed)
            if ($recipesNutrient->getType() === $this) {
                $recipesNutrient->setType(null);
            }
        }

        return $this;
    }
}
