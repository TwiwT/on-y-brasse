<?php

namespace App\Entity;

use App\Repository\HopStockRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HopStockRepository::class)]
class HopStock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'stocks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Hop $hop_id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $bought_at = null;

    #[ORM\Column]
    private ?float $weight = null;

    #[ORM\Column]
    private ?float $remaining_weight = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHopId(): ?Hop
    {
        return $this->hop_id;
    }

    public function setHopId(?Hop $hop_id): static
    {
        $this->hop_id = $hop_id;

        return $this;
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
}
