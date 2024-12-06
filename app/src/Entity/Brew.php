<?php

namespace App\Entity;

use App\Repository\BrewRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BrewRepository::class)]
class Brew
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?float $target_volume = null;

    #[ORM\Column(nullable: true)]
    private ?float $alcool = null;

    /**
     * @var Collection<int, BrewHistory>
     */
    #[ORM\OneToMany(targetEntity: BrewHistory::class, mappedBy: 'brew_id')]
    private Collection $histories;

    #[ORM\OneToOne(mappedBy: 'brew_id', cascade: ['persist', 'remove'])]
    private ?BrewMashing $mashing = null;

    #[ORM\OneToOne(mappedBy: 'brew_id', cascade: ['persist', 'remove'])]
    private ?BrewBoiling $boiling = null;

    /**
     * @var Collection<int, BrewHopping>
     */
    #[ORM\OneToMany(targetEntity: BrewHopping::class, mappedBy: 'brew_id')]
    private Collection $hoppings;

    #[ORM\OneToOne(mappedBy: 'brew_id', cascade: ['persist', 'remove'])]
    private ?BrewFermentation $fermentation = null;

    #[ORM\OneToOne(mappedBy: 'brew_id', cascade: ['persist', 'remove'])]
    private ?BrewBottling $bottling = null;

    #[ORM\Column(nullable: true)]
    private ?int $density_initial = null;

    #[ORM\Column(nullable: true)]
    private ?int $density_final = null;

    public function __construct()
    {
        $this->histories = new ArrayCollection();
        $this->hoppings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
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

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getTargetVolume(): ?float
    {
        return $this->target_volume;
    }

    public function setTargetVolume(float $target_volume): static
    {
        $this->target_volume = $target_volume;

        return $this;
    }

    public function getAlcool(): ?float
    {
        return $this->alcool;
    }

    public function setAlcool(?float $alcool): static
    {
        $this->alcool = $alcool;

        return $this;
    }

    /**
     * @return Collection<int, BrewHistory>
     */
    public function getHistories(): Collection
    {
        return $this->histories;
    }

    public function addHistory(BrewHistory $history): static
    {
        if (!$this->histories->contains($history)) {
            $this->histories->add($history);
            $history->setBrewId($this);
        }

        return $this;
    }

    public function removeHistory(BrewHistory $history): static
    {
        if ($this->histories->removeElement($history)) {
            // set the owning side to null (unless already changed)
            if ($history->getBrewId() === $this) {
                $history->setBrewId(null);
            }
        }

        return $this;
    }

    public function getMashing(): ?BrewMashing
    {
        return $this->mashing;
    }

    public function setMashing(BrewMashing $mashing): static
    {
        // set the owning side of the relation if necessary
        if ($mashing->getBrewId() !== $this) {
            $mashing->setBrewId($this);
        }

        $this->mashing = $mashing;

        return $this;
    }

    public function getBoiling(): ?BrewBoiling
    {
        return $this->boiling;
    }

    public function setBoiling(BrewBoiling $boiling): static
    {
        // set the owning side of the relation if necessary
        if ($boiling->getBrewId() !== $this) {
            $boiling->setBrewId($this);
        }

        $this->boiling = $boiling;

        return $this;
    }

    /**
     * @return Collection<int, BrewHopping>
     */
    public function getHoppings(): Collection
    {
        return $this->hoppings;
    }

    public function addHopping(BrewHopping $hopping): static
    {
        if (!$this->hoppings->contains($hopping)) {
            $this->hoppings->add($hopping);
            $hopping->setBrewId($this);
        }

        return $this;
    }

    public function removeHopping(BrewHopping $hopping): static
    {
        if ($this->hoppings->removeElement($hopping)) {
            // set the owning side to null (unless already changed)
            if ($hopping->getBrewId() === $this) {
                $hopping->setBrewId(null);
            }
        }

        return $this;
    }

    public function getFermentation(): ?BrewFermentation
    {
        return $this->fermentation;
    }

    public function setFermentation(BrewFermentation $fermentation): static
    {
        // set the owning side of the relation if necessary
        if ($fermentation->getBrewId() !== $this) {
            $fermentation->setBrewId($this);
        }

        $this->fermentation = $fermentation;

        return $this;
    }

    public function getBottling(): ?BrewBottling
    {
        return $this->bottling;
    }

    public function setBottling(BrewBottling $bottling): static
    {
        // set the owning side of the relation if necessary
        if ($bottling->getBrewId() !== $this) {
            $bottling->setBrewId($this);
        }

        $this->bottling = $bottling;

        return $this;
    }

    public function getDensityInitial(): ?int
    {
        return $this->density_initial;
    }

    public function setDensityInitial(?int $density_initial): static
    {
        $this->density_initial = $density_initial;

        return $this;
    }

    public function getDensityFinal(): ?int
    {
        return $this->density_final;
    }

    public function setDensityFinal(?int $density_final): static
    {
        $this->density_final = $density_final;

        return $this;
    }
}
