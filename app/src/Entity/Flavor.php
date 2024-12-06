<?php

namespace App\Entity;

use App\Repository\FlavorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FlavorRepository::class)]
class Flavor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Hop>
     */
    #[ORM\ManyToMany(targetEntity: Hop::class, mappedBy: 'flavors')]
    private Collection $hops;

    public function __construct()
    {
        $this->hops = new ArrayCollection();
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

    /**
     * @return Collection<int, Hop>
     */
    public function getHops(): Collection
    {
        return $this->hops;
    }

    public function addHop(Hop $hop): static
    {
        if (!$this->hops->contains($hop)) {
            $this->hops->add($hop);
            $hop->addFlavor($this);
        }

        return $this;
    }

    public function removeHop(Hop $hop): static
    {
        if ($this->hops->removeElement($hop)) {
            $hop->removeFlavor($this);
        }

        return $this;
    }
}
