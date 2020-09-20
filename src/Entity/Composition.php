<?php

namespace App\Entity;

use App\Repository\CompositionRepository;
use Doctrine\ORM\Mapping as ORM;

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
     * @Assert\NotNull(message="The title can't be null.")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="json")
     * @Assert\NotNull(message="The notes list can't be null.")
     * @Assert\Json(
     *     message = "You've entered an invalid Json."
     * )
     */
    private $movementList = [];

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="compositions")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="The user can't be null.")
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
