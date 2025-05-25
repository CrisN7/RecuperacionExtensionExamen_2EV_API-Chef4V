<?php

namespace App\Entity;

use App\Repository\RatingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RatingRepository::class)]
class Rating
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numberVotes = null;

    #[ORM\Column]
    private ?float $ratingAvg = null;

    #[ORM\ManyToOne(inversedBy: 'rating')]
    private ?Recipe $recipe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberVotes(): ?int
    {
        return $this->numberVotes;
    }

    public function setNumberVotes(int $numberVotes): static
    {
        $this->numberVotes = $numberVotes;

        return $this;
    }

    public function getRatingAvg(): ?float
    {
        return $this->ratingAvg;
    }

    public function setRatingAvg(float $ratingAvg): static
    {
        $this->ratingAvg = $ratingAvg;

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
