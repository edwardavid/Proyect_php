<?php

namespace App\Entity;

use App\Repository\DebilidadRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DebilidadRepository::class)]
class Debilidad
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Pokemon>
     */
    #[ORM\ManyToMany(targetEntity: Pokemon::class, mappedBy: 'debilidades')]
    private Collection $poekmons;

    public function __construct()
    {
        $this->poekmons = new ArrayCollection();
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
     * @return Collection<int, Pokemon>
     */
    public function getPoekmons(): Collection
    {
        return $this->poekmons;
    }

    public function addPoekmon(Pokemon $poekmon): static
    {
        if (!$this->poekmons->contains($poekmon)) {
            $this->poekmons->add($poekmon);
            $poekmon->addDebilidade($this);
        }

        return $this;
    }

    public function removePoekmon(Pokemon $poekmon): static
    {
        if ($this->poekmons->removeElement($poekmon)) {
            $poekmon->removeDebilidade($this);
        }

        return $this;
    }
}
