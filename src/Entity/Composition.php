<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CompositionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CompositionRepository::class)
 */
class Composition
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=percussion::class)
     */
    private $percussions;

    public function __construct()
    {
        $this->percussions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|percussion[]
     */
    public function getPercussions(): Collection
    {
        return $this->percussions;
    }

    public function addPercussion(percussion $percussion): self
    {
        if (!$this->percussions->contains($percussion)) {
            $this->percussions[] = $percussion;
        }

        return $this;
    }

    public function removePercussion(percussion $percussion): self
    {
        if ($this->percussions->contains($percussion)) {
            $this->percussions->removeElement($percussion);
        }

        return $this;
    }
}
