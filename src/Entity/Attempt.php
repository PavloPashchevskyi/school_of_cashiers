<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\AttemptRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AttemptRepository::class)
 */
class Attempt
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="attempts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Test::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $test;

    /**
     * @ORM\Column(type="smallint")
     */
    private $numberOfPoints = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $startTimestamp = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $endTimestamp = 0;

    /**
     * @ORM\OneToMany(targetEntity=Answer::class, mappedBy="attempt", orphanRemoval=true)
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

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTest(): Test
    {
        return $this->test;
    }

    public function setTest(Test $test): self
    {
        $this->test = $test;

        return $this;
    }

    public function getNumberOfPoints(): int
    {
        return $this->numberOfPoints;
    }

    public function setNumberOfPoints(int $numberOfPoints): self
    {
        $this->numberOfPoints = $numberOfPoints;

        return $this;
    }

    public function getStartTimestamp(): int
    {
        return $this->startTimestamp;
    }

    public function setStartTimestamp(int $startTimestamp): self
    {
        $this->startTimestamp = $startTimestamp;

        return $this;
    }

    public function getEndTimestamp(): int
    {
        return $this->endTimestamp;
    }

    public function setEndTimestamp(int $endTimestamp): self
    {
        $this->endTimestamp = $endTimestamp;

        return $this;
    }

    /**
     * @return Collection|Answer[]
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setAttempt($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
            // set the owning side to null (unless already changed)
            if ($answer->getAttempt() === $this) {
                $answer->setAttempt(null);
            }
        }

        return $this;
    }
}
