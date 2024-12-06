<?php

namespace App\Entity;

use App\Repository\BrewBottlingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BrewBottlingRepository::class)]
class BrewBottling
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'bottling', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Brew $brew_id = null;

    #[ORM\Column]
    private ?float $sugar = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $details = null;

    #[ORM\Column(nullable: true)]
    private ?float $final_volume = null;

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

    public function getSugar(): ?float
    {
        return $this->sugar;
    }

    public function setSugar(float $sugar): static
    {
        $this->sugar = $sugar;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): static
    {
        $this->details = $details;

        return $this;
    }

    public function getFinalVolume(): ?float
    {
        return $this->final_volume;
    }

    public function setFinalVolume(?float $final_volume): static
    {
        $this->final_volume = $final_volume;

        return $this;
    }
}
