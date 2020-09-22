<?php

namespace App\Entity;

use App\Repository\ScoreRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ScoreRepository::class)
 */
class Score
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Le titre doit être défini.")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Le titre de la partition doit avoir moins de {{ limit }} caractères.",
     *      allowEmptyString = false
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="json")
     * @Assert\NotNull(message="La liste des notes ne peut être vide.")
     * @Assert\Json(
     *     message = "Json invalide"
     * )
     */
    private $noteList = [];

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="scores")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="L'utilisat.eur.rice ne peut pas être nul.le.")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getNoteList(): ?array
    {
        return $this->noteList;
    }

    public function setNoteList(array $noteList): self
    {
        $this->noteList = $noteList;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
