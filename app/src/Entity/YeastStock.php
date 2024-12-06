<?php

namespace App\Entity;

use App\Repository\YeastStockRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: YeastStockRepository::class)]
class YeastStock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'stocks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Yeast $yeast_id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $use_by_date = null;

    #[ORM\Column]
    private ?float $weight = null;

    #[ORM\Column]
    private ?float $remaining_weight = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYeastId(): ?Yeast
    {
        return $this->yeast_id;
    }

    public function setYeastId(?Yeast $yeast_id): static
    {
        $this->yeast_id = $yeast_id;

        return $this;
    }

    public function getUseByDate(): ?\DateTimeImmutable
    {
        return $this->use_by_date;
    }

    public function setUseByDate(\DateTimeImmutable $use_by_date): static
    {
        $this->use_by_date = $use_by_date;

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
