<?php

namespace App\Entity;

use App\Repository\GrainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GrainRepository::class)]
class Grain
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $brand = null;

    #[ORM\Column]
    private ?int $ebc = null;

    /**
     * @var Collection<int, GrainStock>
     */
    #[ORM\OneToMany(targetEntity: GrainStock::class, mappedBy: 'grain_id', orphanRemoval: true)]
    private Collection $stocks;

    public function __construct()
    {
        $this->stocks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getEbc(): ?int
    {
        return $this->ebc;
    }

    public function setEbc(int $ebc): static
    {
        $this->ebc = $ebc;

        return $this;
    }

    /**
     * @return Collection<int, GrainStock>
     */
    public function getStocks(): Collection
    {
        return $this->stocks;
    }

    public function addGrainStock(GrainStock $stock): static
    {
        if (!$this->stocks->contains($stock)) {
            $this->stocks->add($stock);
            $stock->setGrainId($this);
        }

        return $this;
    }

    public function removeGrainStock(GrainStock $stock): static
    {
        if ($this->stocks->removeElement($stock)) {
            // set the owning side to null (unless already changed)
            if ($stock->getGrainId() === $this) {
                $stock->setGrainId(null);
            }
        }

        return $this;
    }
}
