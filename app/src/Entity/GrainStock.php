<?php

namespace App\Entity;

use App\Repository\GrainStockRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GrainStockRepository::class)]
class GrainStock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $bought_at = null;

    #[ORM\Column]
    private ?float $weight = null;

    #[ORM\Column]
    private ?float $remaining_weight = null;

    #[ORM\ManyToOne(inversedBy: 'grainStocks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Grain $grain_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBoughtAt(): ?\DateTimeImmutable
    {
        return $this->bought_at;
    }

    public function setBoughtAt(\DateTimeImmutable $bought_at): static
    {
        $this->bought_at = $bought_at;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getRemainingWeight(): ?float
    {
        return $this->remaining_weight;
    }

    public function setRemainingWeight(float $remaining_weight): static
    {
        $this->remaining_weight = $remaining_weight;

        return $this;
    }

    public function getGrainId(): ?Grain
    {
        return $this->grain_id;
    }

    public function setGrainId(?Grain $grain_id): static
    {
        $this->grain_id = $grain_id;

        return $this;
    }
}
