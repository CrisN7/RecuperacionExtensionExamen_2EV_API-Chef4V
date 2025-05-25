<?php
namespace App\Model;

class RatingDTO
{
    public function __construct(
        public int $numberVotes,
        public float $ratingAvg,
    ){}
}
