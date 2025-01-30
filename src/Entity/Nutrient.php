<?php

namespace App\Entity;

use App\Repository\NutrientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NutrientRepository::class)]
class Nutrient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    private ?string $unidadDeMedida = null;

    /**
     * @var Collection<int, Receta>
     */
    #[ORM\ManyToMany(targetEntity: Receta::class)]
    private Collection $recetas;

    public function __construct()
    {
        $this->recetas = new ArrayCollection();
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

    public function getUnidadDeMedida(): ?string
    {
        return $this->unidadDeMedida;
    }

    public function setUnidadDeMedida(string $unidadDeMedida): static
    {
        $this->unidadDeMedida = $unidadDeMedida;

        return $this;
    }

    /**
     * @return Collection<int, Receta>
     */
    public function getRecetas(): Collection
    {
        return $this->recetas;
    }

    public function addReceta(Receta $receta): static
    {
        if (!$this->recetas->contains($receta)) {
            $this->recetas->add($receta);
        }

        return $this;
    }

    public function removeReceta(Receta $receta): static
    {
        $this->recetas->removeElement($receta);

        return $this;
    }
}
