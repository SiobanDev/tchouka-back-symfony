<?php

namespace App\Entity;

use App\Repository\CompositionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CompositionRepository::class)
 */
class Composition
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
     *      maxMessage = "Le titre de la composition doit avoir moins de {{ limit }} caractères.",
     *      allowEmptyString = false
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="json")
     * @Assert\NotNull(message="La liste des mouvements ne peut être vide.")
     * @Assert\Json(
     *     message = "Json invalide"
     * )
     */
    private $movementList = [];

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="compositions")
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

    public function getMovementList(): ?array
    {
        return $this->movementList;
    }

    public function setMovementList(array $movementList): self
    {
        $this->movementList = $movementList;

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
