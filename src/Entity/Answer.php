<?php

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnswerRepository::class)
 */
class Answer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Attempt::class, inversedBy="answers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $attempt;

    /**
     * @ORM\Column(type="integer")
     */
    private $variant_id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $value;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAttempt(): Attempt
    {
        return $this->attempt;
    }

    public function setAttempt(Attempt $attempt): self
    {
        $this->attempt = $attempt;

        return $this;
    }

    public function getVariantId(): int
    {
        return $this->variant_id;
    }

    public function setVariantId(int $variant_id): self
    {
        $this->variant_id = $variant_id;

        return $this;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }
}
