<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DocumentRepository")
 */
class Document
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
     * @ORM\Column(type="date")
     */
    private $createdat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**  
     * @ORM\Column(type="integer")
     */
    private $id_ens;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $departement;

    

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

    public function getCreatedat(): ?\DateTimeInterface
    {
        return $this->createdat;
    }

    public function setCreatedat(\DateTimeInterface $createdat): self
    {
        $this->createdat = $createdat;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getIdEns(): ?int
    {
        return $this->id_ens;
    }

    public function setIdEns(int $id_ens): self
    {
        $this->id_ens = $id_ens;

        return $this;
    }

    public function getDepartement(): ?string
    {
        return $this->departement;
    }

    public function setDepartement(string $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    
}
