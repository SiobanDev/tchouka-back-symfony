<?php

namespace App\Entity;

use App\Repository\CompositionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompositionRepository::class)
 */
class Composition
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $compositionId;

    /**
     * @ORM\Column(type="json")
     */
    private $compositionMovementList = [];

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userCompositionList")
     * @ORM\JoinColumn(nullable=false)
     */
    private $compositionUser;

    public function getCompositionId(): ?int
    {
        return $this->compositionId;
    }

    public function getCompositionMovementList(): ?array
    {
        return $this->compositionMovementList;
    }

    public function setCompositionMovementList(array $compositionMovementList): self
    {
        $this->compositionMovementList = $compositionMovementList;

        return $this;
    }

    public function getCompositionUser(): ?User
    {
        return $this->compositionUser;
    }

    public function setCompositionUser(?User $compositionUser): self
    {
        $this->compositionUser = $compositionUser;

        return $this;
    }
}
