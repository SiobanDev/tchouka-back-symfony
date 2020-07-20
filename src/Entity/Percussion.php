<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=PercussionRepository::class)
 */
class Percussion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Note::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity=Movement::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $movement;


    public function __construct()
    {
       
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?note
    {
        return $this->note;
    }

    public function setNote(?note $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getMovement(): ?movement
    {
        return $this->movement;
    }

    public function setMovement(?movement $movement): self
    {
        $this->movement = $movement;

        return $this;
    }
}
