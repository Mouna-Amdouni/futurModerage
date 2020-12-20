<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;
        /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;
      /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $departement;

    /**
     * @ORM\Column(type="integer")
     */
    private $nce;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    
   
    private $birth_date;




    /**
     * @ORM\Column(type="date")
     */
    private $registration_date;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $last_login;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Document", mappedBy="id_ens")
     */
    private $docs;

    public function __construct()
    {
        $this->docs = new ArrayCollection();
    }

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // au moins ikoun etudiant
        $roles[] = 'ROLE_ETUD';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }
     //-------------------
    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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

    public function getNce(): ?int
    {
        return $this->nce;
    }

    public function setNce(int $nce): self
    {
        $this->nce = $nce;

        return $this;
    }
    //-------------------

    

    

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birth_date;
    }

    public function setBirthDate(?\DateTimeInterface $birth_date): self
    {
        $this->birth_date = $birth_date;

        return $this;
    }




    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registration_date;
    }

    public function setRegistrationDate(\DateTimeInterface $registration_date): self
    {
        $this->registration_date = $registration_date;

        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->last_login;
    }

    public function setLastLogin(?\DateTimeInterface $last_login): self
    {
        $this->last_login = $last_login;

        return $this;
    }

  

    public function roleStr($role) {
        switch ($role) {
            case 'ROLE_ENQU':
                return 'Enqueteur';
                break;
            case 'ROLE_ETUD':
                return 'Etudiant';
                break;
            
            case 'ROLE_ENSE':
                return 'Enseignant';
                break;

            case 'ROLE_ADMIN':
                return 'Administrateur';
                break;
        }
    }

    public function getLastLoginStr($last) {
        $now = new \DateTime();

        $difference = date_diff($last,$now);

        if($difference->format('%y') >= 1) {
            if($difference->format('%y') == 1) {
                $diff = $difference->format('%y')." annee";
            }
            else {
                $diff = $difference->format('%y')." annee";
            }
        }
        else if($difference->format('%i') < 1) {
            $diff = "Just now";
        }
        else if($difference->format('%h') < 1) {
            if($difference->format('%m') == 1) {
                $diff = $difference->format('%i')." minute";
            }
            else {
                $diff = $difference->format('%i')." minutes";
            }
        }
        else if($difference->format('%d') < 1) {
            if($difference->format('%h') == 1) {
                $diff = $difference->format('%h')." heures";
            }
            else {
                $diff = $difference->format('%h')." heures";
            }
        }
        else if($difference->format('%m') < 1) {
            if($difference->format('%d') == 1) {
                $diff = $difference->format('%d')." jrs";
            }
            else {
                $diff = $difference->format('%d')." jrs";
            }
        }
        else if($difference->format('%y') < 1) {
            if($difference->format('%m') == 1) {
                $diff = $difference->format('%m')." mois";
            }
            else {
                $diff = $difference->format('%m')." mois";
            }
        }
        return $diff;
    }

    public function createAvatarFile($username) {
        $file = 'img/users/saves/default.png';
		$newfile = 'img/users/'.$username.'.png';
		if (!copy($file, $newfile)) {
    		echo "<p class='failed'>probleme\n</p>";
		}
		else {
			return $newfile;
		}
    }

  

    /**
     * @return Collection|Document[]
     */
    public function getDocs(): Collection
    {
        return $this->docs;
    }

    public function addDoc(Document $doc): self
    {
        if (!$this->docs->contains($doc)) {
            $this->docs[] = $doc;
            $doc->setIdEns($this);
        }

        return $this;
    }

    public function removeDoc(Document $doc): self
    {
        if ($this->docs->contains($doc)) {
            $this->docs->removeElement($doc);
            if ($doc->getIdEns() === $this) {
                $doc->setIdEns(null);
            }
        }

        return $this;
    }
}
