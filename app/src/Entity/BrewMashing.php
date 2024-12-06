<?php

namespace App\Entity;

use App\Repository\BrewMashingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BrewMashingRepository::class)]
class BrewMashing
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'duration', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Brew $brew_id = null;

    #[ORM\Column]
    private ?int $duration = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $details = null;

    /**
     * @var Collection<int, BrewMashingGrain>
     */
    #[ORM\OneToMany(targetEntity: BrewMashingGrain::class, mappedBy: 'mashing_id')]
    private Collection $grains;

    #[ORM\Column]
    private ?float $water = null;

    #[ORM\Column(nullable: true)]
    private ?float $water_rinsing = null;

    public function __construct()
    {
        $this->grains = new ArrayCollection();
    }

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

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(string $details): static
    {
        $this->details = $details;

        return $this;
    }

    /**
     * @return Collection<int, BrewMashingGrain>
     */
    public function getGrains(): Collection
    {
        return $this->grains;
    }

    public function addGrain(BrewMashingGrain $grain): static
    {
        if (!$this->grains->contains($grain)) {
            $this->grains->add($grain);
            $grain->setMashingId($this);
        }

        return $this;
    }

    public function removeGrain(BrewMashingGrain $grain): static
    {
        if ($this->grains->removeElement($grain)) {
            // set the owning side to null (unless already changed)
            if ($grain->getMashingId() === $this) {
                $grain->setMashingId(null);
            }
        }

        return $this;
    }

    public function getWater(): ?float
    {
        return $this->water;
    }

    public function setWater(float $water): static
    {
        $this->water = $water;

        return $this;
    }

    public function getWaterRinsing(): ?float
    {
        return $this->water_rinsing;
    }

    public function setWaterRinsing(?float $water_rinsing): static
    {
        $this->water_rinsing = $water_rinsing;

        return $this;
    }
}
