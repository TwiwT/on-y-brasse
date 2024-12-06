<?php

namespace App\Entity;

use App\Repository\BrewFermentationYeastRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BrewFermentationYeastRepository::class)]
class BrewFermentationYeast
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'brewFermentationYeasts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Yeast $yeast_id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $details = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYeastId(): ?Yeast
    {
        return $this->yeast_id;
    }

    public function setYeastId(?Yeast $yeast_id): static
    {
        $this->yeast_id = $yeast_id;

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
}
