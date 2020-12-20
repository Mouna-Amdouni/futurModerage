<?php

namespace App\Entity;

use App\Repository\SondageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SondageRepository::class)
 */
class Sondage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titre;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbParticipant;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbQuestion;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbReponse;

    /**
     * @ORM\OneToMany(targetEntity=Question::class, mappedBy="sondage", orphanRemoval=true)
     */
    private $Questions;

    /**
     * @ORM\OneToMany(targetEntity=QuestionChoixMultiples::class, mappedBy="sondage")
     */
    private $questionChoixMultiples;

    /**
     * @ORM\ManyToOne(targetEntity=Enqueteur::class, inversedBy="sondages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $enqueteur;

    /**
     * @ORM\ManyToOne(targetEntity=Sujet::class, inversedBy="sondages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sujet;

    public function __construct()
    {
        $this->Questions = new ArrayCollection();
        $this->questionChoixMultiples = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getNbParticipant(): ?int
    {
        return $this->nbParticipant;
    }

    public function setNbParticipant(?int $nbParticipant): self
    {
        $this->nbParticipant = $nbParticipant;

        return $this;
    }

    public function getNbQuestion(): ?int
    {
        return $this->nbQuestion;
    }

    public function setNbQuestion(?int $nbQuestion): self
    {
        $this->nbQuestion = $nbQuestion;

        return $this;
    }

    public function getNbReponse(): ?int
    {
        return $this->nbReponse;
    }

    public function setNbReponse(?int $nbReponse): self
    {
        $this->nbReponse = $nbReponse;

        return $this;

    }

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection
    {
        return $this->Questions;
    }

    public function addQuestion(Question $question): self
    {
        $this->questions[] = $question;
        $question->setSondage($this);


        return $this;


    }
    public function __toString(){
        // to show the name of the Category in the select
        return $this->titre;
        // to show the id of the Category in the select
        // return $this->id;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->Questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getSondage() === $this) {
                $question->setSondage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|QuestionChoixMultiples[]
     */
    public function getQuestionChoixMultiples(): Collection
    {
        return $this->questionChoixMultiples;
    }

    public function addQuestionChoixMultiple(QuestionChoixMultiples $questionChoixMultiple): self
    {
        if (!$this->questionChoixMultiples->contains($questionChoixMultiple)) {
            $this->questionChoixMultiples[] = $questionChoixMultiple;
            $questionChoixMultiple->setSondage($this);
        }

        return $this;
    }

    public function removeQuestionChoixMultiple(QuestionChoixMultiples $questionChoixMultiple): self
    {
        if ($this->questionChoixMultiples->removeElement($questionChoixMultiple)) {
            // set the owning side to null (unless already changed)
            if ($questionChoixMultiple->getSondage() === $this) {
                $questionChoixMultiple->setSondage(null);
            }
        }

        return $this;
    }

    public function getEnqueteur(): ?Enqueteur
    {
        return $this->enqueteur;
    }

    public function setEnqueteur(?Enqueteur $enqueteur): self
    {
        $this->enqueteur = $enqueteur;

        return $this;
    }

    public function getSujet(): ?Sujet
    {
        return $this->sujet;
    }

    public function setSujet(?Sujet $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }
}
