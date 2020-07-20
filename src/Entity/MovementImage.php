<?php

namespace App\Entity;

use App\Repository\MovementImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MovementImageRepository::class)
 */
class MovementImage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $source;

    /**
     * @ORM\ManyToOne(targetEntity=Movement::class, inversedBy="movementImages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $movement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getMovement(): ?Movement
    {
        return $this->movement;
    }

    public function setMovement(?Movement $movement): self
    {
        $this->movement = $movement;

        return $this;
    }
}
