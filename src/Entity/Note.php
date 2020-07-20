<?php

namespace App\Entity;

use App\Repository\NoteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NoteRepository::class)
 */
class Note
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

        /**
     * @ORM\Column(type="string", length=255)
     */
    private $noteImage;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }


    public function getNoteImage(): ?string
    {
        return $this->noteImage;
    }

    public function setNoteImage(string $noteImage): self
    {
        $this->noteImage = $noteImage;

        return $this;
    }

}
