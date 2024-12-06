<?php

namespace App\Entity;

use App\Repository\BrewHoppingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BrewHoppingRepository::class)]
class BrewHopping
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'hoppings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Brew $brew_id = null;

    #[ORM\ManyToOne(inversedBy: 'bew_hoppings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Hop $hop_id = null;

    #[ORM\Column]
    private ?int $weight = null;

    #[ORM\Column(length: 255)]
    private ?string $add_at = null;

    #[ORM\Column(nullable: true)]
    private ?int $sort = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrewId(): ?Brew
    {
        return $this->brew_id;
    }

    public function setBrewId(?Brew $brew_id): static
    {
        $this->brew_id = $brew_id;

        return $this;
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

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getAddAt(): ?string
    {
        return $this->add_at;
    }

    public function setAddAt(string $add_at): static
    {
        $this->add_at = $add_at;

        return $this;
    }

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(?int $sort): static
    {
        $this->sort = $sort;

        return $this;
    }
}
