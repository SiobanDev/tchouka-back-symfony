<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;


    /**
     * @ORM\OneToMany(targetEntity=Composition::class, mappedBy="compositionUser", orphanRemoval=true)
     */
    private $userCompositionList;

    /**
     * @ORM\OneToMany(targetEntity=Score::class, mappedBy="scoreUser", orphanRemoval=true)
     */
    private $userScoreList;


    public function __construct()
    {
        $this->userCompositionList = new ArrayCollection();
        $this->userScoreList = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }


    /**
     * @return Collection|Composition[]
     */
    public function getUserCompositionList(): Collection
    {
        return $this->userCompositionList;
    }

    public function addUserCompositionList(Composition $userCompositionList): self
    {
        if (!$this->userCompositionList->contains($userCompositionList)) {
            $this->userCompositionList[] = $userCompositionList;
            $userCompositionList->setCompositionUser($this);
        }

        return $this;
    }

    public function removeUserCompositionList(Composition $userCompositionList): self
    {
        if ($this->userCompositionList->contains($userCompositionList)) {
            $this->userCompositionList->removeElement($userCompositionList);
            // set the owning side to null (unless already changed)
            if ($userCompositionList->getCompositionUser() === $this) {
                $userCompositionList->setCompositionUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Score[]
     */
    public function getUserScoreList(): Collection
    {
        return $this->userScoreList;
    }

    public function addUserScoreList(Score $userScoreList): self
    {
        if (!$this->userScoreList->contains($userScoreList)) {
            $this->userScoreList[] = $userScoreList;
            $userScoreList->setScoreUser($this);
        }

        return $this;
    }

    public function removeUserScoreList(Score $userScoreList): self
    {
        if ($this->userScoreList->contains($userScoreList)) {
            $this->userScoreList->removeElement($userScoreList);
            // set the owning side to null (unless already changed)
            if ($userScoreList->getScoreUser() === $this) {
                $userScoreList->setScoreUser(null);
            }
        }

        return $this;
    }
}
