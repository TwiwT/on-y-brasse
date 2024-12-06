<?php

namespace App\Entity;

use App\Repository\HopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HopRepository::class)]
class Hop
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $acid_alpha = null;

    /**
     * @var Collection<int, Flavor>
     */
    #[ORM\ManyToMany(targetEntity: Flavor::class, inversedBy: 'hops')]
    private Collection $flavors;

    /**
     * @var Collection<int, HopStock>
     */
    #[ORM\OneToMany(targetEntity: HopStock::class, mappedBy: 'hop_id')]
    private Collection $stocks;

    public function __construct()
    {
        $this->flavors = new ArrayCollection();
        $this->stocks = new ArrayCollection();
        $this->hoppings = new ArrayCollection();
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

    public function getAcidAlpha(): ?float
    {
        return $this->acid_alpha;
    }

    public function setAcidAlpha(float $acid_alpha): static
    {
        $this->acid_alpha = $acid_alpha;

        return $this;
    }

    /**
     * @return Collection<int, Flavor>
     */
    public function getFlavors(): Collection
    {
        return $this->flavors;
    }

    public function addFlavor(Flavor $flavor): static
    {
        if (!$this->flavors->contains($flavor)) {
            $this->flavors->add($flavor);
        }

        return $this;
    }

    public function removeFlavor(Flavor $flavor): static
    {
        $this->flavors->removeElement($flavor);

        return $this;
    }

    /**
     * @return Collection<int, HopStock>
     */
    public function getStocks(): Collection
    {
        return $this->stocks;
    }

    public function addStock(HopStock $stock): static
    {
        if (!$this->stocks->contains($stock)) {
            $this->stocks->add($stock);
            $stock->setHopId($this);
        }

        return $this;
    }

    public function removeStock(HopStock $stock): static
    {
        if ($this->stocks->removeElement($stock)) {
            // set the owning side to null (unless already changed)
            if ($stock->getHopId() === $this) {
                $stock->setHopId(null);
            }
        }

        return $this;
    }
}
