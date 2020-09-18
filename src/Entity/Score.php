<?php

namespace App\Entity;

use App\Repository\ScoreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ScoreRepository::class)
 */
class Score
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $scoreId;

    /**
     * @ORM\Column(type="json")
     */
    private $scoreNoteList = [];

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userScoreList")
     * @ORM\JoinColumn(nullable=false)
     */
    private $scoreUser;

    public function getScoreId(): ?int
    {
        return $this->scoreId;
    }

    public function getScoreNoteList(): ?array
    {
        return $this->scoreNoteList;
    }

    public function setScoreNoteList(array $scoreNoteList): self
    {
        $this->scoreNoteList = $scoreNoteList;

        return $this;
    }

    public function getScoreUser(): ?User
    {
        return $this->scoreUser;
    }

    public function setScoreUser(?User $scoreUser): self
    {
        $this->scoreUser = $scoreUser;

        return $this;
    }
}
