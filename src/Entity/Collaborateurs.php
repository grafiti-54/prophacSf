<?php

namespace App\Entity;

use App\Repository\CollaborateursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: CollaborateursRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Collaborateurs implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 55, nullable: true)]
    private $nom;

    #[ORM\Column(type: 'string', length: 55, nullable: true)]
    private $prenom;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $photo;

    #[ORM\ManyToMany(targetEntity: Qualifications::class, inversedBy: 'collaborateurs')]
    private $qualification;

    #[ORM\ManyToOne(targetEntity: Telephones::class, inversedBy: 'collaborateurs')]
    private $numero;

    #[ORM\ManyToMany(targetEntity: Departements::class, mappedBy: 'collaborateur')]
    private $departements;

    #[ORM\OneToMany(mappedBy: 'collaborateur', targetEntity: Articles::class)]
    private $articles;

    public function __construct()
    {
        $this->qualification = new ArrayCollection();
        $this->departements = new ArrayCollection();
        $this->articles = new ArrayCollection();
    }

    //correction could not be converted to string
    public function __toString()
    {
        return $this->nom;
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
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @return Collection<int, Qualifications>
     */
    public function getQualification(): Collection
    {
        return $this->qualification;
    }

    public function addQualification(Qualifications $qualification): self
    {
        if (!$this->qualification->contains($qualification)) {
            $this->qualification[] = $qualification;
        }

        return $this;
    }

    public function removeQualification(Qualifications $qualification): self
    {
        $this->qualification->removeElement($qualification);

        return $this;
    }

    public function getNumero(): ?Telephones
    {
        return $this->numero;
    }

    public function setNumero(?Telephones $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * @return Collection<int, Departements>
     */
    public function getDepartements(): Collection
    {
        return $this->departements;
    }

    public function addDepartement(Departements $departement): self
    {
        if (!$this->departements->contains($departement)) {
            $this->departements[] = $departement;
            $departement->addCollaborateur($this);
        }

        return $this;
    }

    public function removeDepartement(Departements $departement): self
    {
        if ($this->departements->removeElement($departement)) {
            $departement->removeCollaborateur($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Articles>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Articles $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setCollaborateur($this);
        }

        return $this;
    }

    public function removeArticle(Articles $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getCollaborateur() === $this) {
                $article->setCollaborateur(null);
            }
        }

        return $this;
    }
}
