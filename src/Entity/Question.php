<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 */
class Question
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $Text;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Quiz", inversedBy="Question")
     */
    private $Quiz;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\QuestionOption", mappedBy="Question", orphanRemoval=true)
     */
    private $questionOptions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Answers", mappedBy="Question", orphanRemoval=true)
     */
    private $answers;

    public function __construct()
    {
        $this->Quiz = new ArrayCollection();
        $this->questionOptions = new ArrayCollection();
        $this->answers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->Text;
    }

    public function setText(string $Text): self
    {
        $this->Text = $Text;

        return $this;
    }

    /**
     * @return Collection|Quiz[]
     */
    public function getQuiz(): Collection
    {
        return $this->Quiz;
    }

    public function addQuiz(Quiz $quiz): self
    {
        if (!$this->Quiz->contains($quiz)) {
            $this->Quiz[] = $quiz;
        }

        return $this;
    }

    public function removeQuiz(Quiz $quiz): self
    {
        if ($this->Quiz->contains($quiz)) {
            $this->Quiz->removeElement($quiz);
        }

        return $this;
    }

    /**
     * @return Collection|QuestionOption[]
     */
    public function getQuestionOptions(): Collection
    {
        return $this->questionOptions;
    }

    public function addQuestionOption(QuestionOption $questionOption): self
    {
        if (!$this->questionOptions->contains($questionOption)) {
            $this->questionOptions[] = $questionOption;
            $questionOption->setQuestion($this);
        }

        return $this;
    }

    public function removeQuestionOption(QuestionOption $questionOption): self
    {
        if ($this->questionOptions->contains($questionOption)) {
            $this->questionOptions->removeElement($questionOption);
            // set the owning side to null (unless already changed)
            if ($questionOption->getQuestion() === $this) {
                $questionOption->setQuestion(null);
            }
        }

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
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(Answers $answer): self
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
            // set the owning side to null (unless already changed)
            if ($answer->getQuestion() === $this) {
                $answer->setQuestion(null);
            }
        }

        return $this;
    }
}
