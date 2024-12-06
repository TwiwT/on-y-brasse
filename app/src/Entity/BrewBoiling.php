<?php

namespace App\Entity;

use App\Repository\BrewBoilingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BrewBoilingRepository::class)]
class BrewBoiling
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'boiling', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Brew $brew_id = null;

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
}
