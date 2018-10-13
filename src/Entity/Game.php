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
    private $quiz;

    /**
     * @ORM\Column(type="datetime")
     */
    private $timeStart;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
  
    private $timeEnd;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $score;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Answers", mappedBy="Game")
     */
    private $answers;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="games")
     */
    private $user;

    public function __construct(?Quiz $quiz, ?User $user)
    {
        $this->answers = new ArrayCollection();
        $this->timeStart = new \DateTime();
        $this->quiz = $quiz;
        $this->user = $user;
        $this->score = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): self
    {
        $this->quiz = $quiz;

        return $this;
    }

    public function getTimeStart(): ?\DateTimeInterface
    {
        return $this->timeStart;
    }

    public function setTimeStart(\DateTimeInterface $timeStart): self
    {
        $this->timeStart = $timeStart;

        return $this;
    }

    public function getTimeEnd(): ?\DateTimeInterface
    {

        return $this->timeEnd;
    }

    public function setTimeEnd(?\DateTimeInterface $timeEnd): self
    {
        $this->timeEnd = $timeEnd;


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
