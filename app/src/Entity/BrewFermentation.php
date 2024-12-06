<?php

namespace App\Entity;

use App\Repository\BrewFermentationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BrewFermentationRepository::class)]
class BrewFermentation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'fermentation', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Brew $brew_id = null;

    #[ORM\Column]
    private ?int $duration = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrewId(): ?Brew
    {
        return $this->brew_id;
    }

    public function setBrewId(Brew $brew_id): static
    {
        $this->brew_id = $brew_id;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }
}
