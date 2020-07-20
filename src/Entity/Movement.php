<?php

namespace App\Entity;

use App\Repository\MovementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MovementRepository::class)
 */
class Movement
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
    private $wordToSing;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sound;

    /**
     * @ORM\OneToMany(targetEntity=MovementImage::class, mappedBy="movement", orphanRemoval=true)
     */
    private $movementImages;


    public function __construct()
    {
        $this->movementImages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWordToSing(): ?string
    {
        return $this->wordToSing;
    }

    public function setWordToSing(string $wordToSing): self
    {
        $this->wordToSing = $wordToSing;

        return $this;
    }

    public function getSound(): ?string
    {
        return $this->sound;
    }

    public function setSound(string $sound): self
    {
        $this->sound = $sound;

        return $this;
    }

    /**
     * @return Collection|MovementImage[]
     */
    public function getMovementImages(): Collection
    {
        return $this->movementImages;
    }

    public function addMovementImage(MovementImage $movementImage): self
    {
        if (!$this->movementImages->contains($movementImage)) {
            $this->movementImages[] = $movementImage;
            $movementImage->setMovement($this);
        }

        return $this;
    }

    public function removeMovementImage(MovementImage $movementImage): self
    {
        if ($this->movementImages->contains($movementImage)) {
            $this->movementImages->removeElement($movementImage);
            // set the owning side to null (unless already changed)
            if ($movementImage->getMovement() === $this) {
                $movementImage->setMovement(null);
            }
        }

        return $this;
    }
}
