<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TravailRepository")
 */
class Travail
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomdoc;

    /**
     * @ORM\Column(type="integer")
     */
    private $idetudiant;

    /**
     * @ORM\Column(type="integer",  nullable=true)
     */
    private $idEnseignant;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $remarque;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomdoc(): ?string
    {
        return $this->nomdoc;
    }

    public function setNomdoc(string $nomdoc): self
    {
        $this->nomdoc = $nomdoc;

        return $this;
    }

    public function getIdetudiant(): ?int
    {
        return $this->idetudiant;
    }

    public function setIdetudiant(int $idetudiant): self
    {
        $this->idetudiant = $idetudiant;

        return $this;
    }

    public function getIdEnseignant(): ?int
    {
        return $this->idEnseignant;
    }

    public function setIdEnseignant(int $idEnseignant): self
    {
        $this->idEnseignant = $idEnseignant;

        return $this;
    }

    public function getRemarque(): ?string
    {
        return $this->remarque;
    }

    public function setRemarque(?string $remarque): self
    {
        $this->remarque = $remarque;

        return $this;
    }
}
