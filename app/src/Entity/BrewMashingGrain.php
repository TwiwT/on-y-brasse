<?php

namespace App\Entity;

use App\Repository\BrewMashingGrainRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BrewMashingGrainRepository::class)]
class BrewMashingGrain
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'grains')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BrewMashing $mashing_id = null;

    #[ORM\Column]
    private ?int $weight = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMashingId(): ?BrewMashing
    {
        return $this->mashing_id;
    }

    public function setMashingId(?BrewMashing $mashing_id): static
    {
        $this->mashing_id = $mashing_id;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): static
    {
        $this->weight = $weight;

        return $this;
    }
}
