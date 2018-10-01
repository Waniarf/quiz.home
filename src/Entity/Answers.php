<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnswersRepository")
 */
class Answers
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Game", inversedBy="answers")
     */
    private $Game;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Question", inversedBy="answers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Question;

    /**
     * @ORM\Column(type="boolean")
     */
    private $IsValid;

    public function __construct()
    {
        $this->Game = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGame(): Collection
    {
        return $this->Game;
    }

    public function addGame(Game $game): self
    {
        if (!$this->Game->contains($game)) {
            $this->Game[] = $game;
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->Game->contains($game)) {
            $this->Game->removeElement($game);
        }

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->Question;
    }

    public function setQuestion(?Question $Question): self
    {
        $this->Question = $Question;

        return $this;
    }

    public function getIsValid(): ?bool
    {
        return $this->IsValid;
    }

    public function setIsValid(bool $IsValid): self
    {
        $this->IsValid = $IsValid;

        return $this;
    }
}
