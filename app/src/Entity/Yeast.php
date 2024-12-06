<?php

namespace App\Entity;

use App\Repository\YeastRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: YeastRepository::class)]
class Yeast
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $flocculation = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    /**
     * @var Collection<int, YeastStock>
     */
    #[ORM\OneToMany(targetEntity: YeastStock::class, mappedBy: 'yeast_id')]
    private Collection $stocks;

    public function __construct()
    {
        $this->stocks = new ArrayCollection();
        $this->brewFermentationYeasts = new ArrayCollection();
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

    public function getFlocculation(): ?int
    {
        return $this->flocculation;
    }

    public function setFlocculation(int $flocculation): static
    {
        $this->flocculation = $flocculation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, YeastStock>
     */
    public function getStocks(): Collection
    {
        return $this->stocks;
    }

    public function addStock(YeastStock $stock): static
    {
        if (!$this->stocks->contains($stock)) {
            $this->stocks->add($stock);
            $stock->setYeastId($this);
        }

        return $this;
    }

    public function removeStock(YeastStock $stock): static
    {
        if ($this->stocks->removeElement($stock)) {
            // set the owning side to null (unless already changed)
            if ($stock->getYeastId() === $this) {
                $stock->setYeastId(null);
            }
        }

        return $this;
    }
}
