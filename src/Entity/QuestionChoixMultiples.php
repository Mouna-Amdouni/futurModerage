<?php

namespace App\Entity;

use App\Repository\QuestionChoixMultiplesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionChoixMultiplesRepository::class)
 */
class QuestionChoixMultiples
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
    private $contenu;

    /**
     * @ORM\OneToMany(targetEntity=ChoixReponse::class, mappedBy="questionChoixMultiples")
     */
    private $choix;

    /**
     * @ORM\OneToMany(targetEntity=Reponse::class, mappedBy="questionMultiChoix")
     */
    private $reponses;

    /**
     * @ORM\ManyToOne(targetEntity=Sondage::class, inversedBy="questionChoixMultiples")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sondage;

    public function __construct()
    {
        $this->choix = new ArrayCollection();
        $this->reponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * @return Collection|ChoixReponse[]
     */
    public function getChoix(): Collection
    {
        return $this->choix;
    }

    public function addChoix(ChoixReponse $choix): self
    {
        if (!$this->choix->contains($choix)) {
            $this->choix[] = $choix;
            $choix->setQuestionChoixMultiples($this);
        }

        return $this;
    }

    public function removeChoix(ChoixReponse $choix): self
    {
        if ($this->choix->removeElement($choix)) {
            // set the owning side to null (unless already changed)
            if ($choix->getQuestionChoixMultiples() === $this) {
                $choix->setQuestionChoixMultiples(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Reponse[]
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponse $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses[] = $reponse;
            $reponse->setQuestionMultiChoix($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        if ($this->reponses->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getQuestionMultiChoix() === $this) {
                $reponse->setQuestionMultiChoix(null);
            }
        }

        return $this;
    }

    public function getSondage(): ?Sondage
    {
        return $this->sondage;
    }

    public function setSondage(?Sondage $sondage): self
    {
        $this->sondage = $sondage;

        return $this;
    }
}
