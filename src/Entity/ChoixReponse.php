<?php

namespace App\Entity;

use App\Repository\ChoixReponseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChoixReponseRepository::class)
 */
class ChoixReponse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity=QuestionChoixMultiples::class, inversedBy="choix")
     * @ORM\JoinColumn(nullable=false)
     */
    private $questionChoixMultiples;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getQuestionChoixMultiples(): ?QuestionChoixMultiples
    {
        return $this->questionChoixMultiples;
    }

    public function setQuestionChoixMultiples(?QuestionChoixMultiples $questionChoixMultiples): self
    {
        $this->questionChoixMultiples = $questionChoixMultiples;

        return $this;
    }
}
