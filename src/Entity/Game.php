<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Quiz", inversedBy="games")
     */
    private $Quiz;

    /**
     * @ORM\Column(type="datetime")
     */
    private $TimeStart;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $TineEnd;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $score;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Answers", mappedBy="Game")
     */
    private $answers;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuiz(): ?Quiz
    {
        return $this->Quiz;
    }

    public function setQuiz(?Quiz $Quiz): self
    {
        $this->Quiz = $Quiz;

        return $this;
    }

    public function getTimeStart(): ?\DateTimeInterface
    {
        return $this->TimeStart;
    }

    public function setTimeStart(\DateTimeInterface $TimeStart): self
    {
        $this->TimeStart = $TimeStart;

        return $this;
    }

    public function getTineEnd(): ?\DateTimeInterface
    {
        return $this->TineEnd;
    }

    public function setTineEnd(?\DateTimeInterface $TineEnd): self
    {
        $this->TineEnd = $TineEnd;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): self
    {
        $this->score = $score;

        return $this;
    }

    /**
     * @return Collection|Answers[]
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answers $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->addGame($this);
        }

        return $this;
    }

    public function removeAnswer(Answers $answer): self
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
            $answer->removeGame($this);
        }

        return $this;
    }
}
