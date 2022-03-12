<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticlesRepository::class)]
class Articles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 150)]
    private $titre;

    #[ORM\Column(type: 'text')]
    private $contenu;

    #[ORM\Column(type: 'date', nullable: true)]
    private $createdDate;

    #[ORM\ManyToOne(targetEntity: Departements::class, inversedBy: 'articles')]
    private $departement;

    #[ORM\ManyToOne(targetEntity: Collaborateurs::class, inversedBy: 'articles')]
    private $collaborateur;

    #[ORM\ManyToMany(targetEntity: Images::class, mappedBy: 'article')]
    private $images;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $illustration;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private $titreIllustration;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private $legendeIllustration;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
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

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->createdDate;
    }

    public function setCreatedDate(?\DateTimeInterface $createdDate): self
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    public function getDepartement(): ?Departements
    {
        return $this->departement;
    }

    public function setDepartement(?Departements $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    public function getCollaborateur(): ?Collaborateurs
    {
        return $this->collaborateur;
    }

    public function setCollaborateur(?Collaborateurs $collaborateur): self
    {
        $this->collaborateur = $collaborateur;

        return $this;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->addArticle($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            $image->removeArticle($this);
        }

        return $this;
    }

    public function getIllustration(): ?string
    {
        return $this->illustration;
    }

    public function setIllustration(?string $illustration): self
    {
        $this->illustration = $illustration;

        return $this;
    }

    public function getTitreIllustration(): ?string
    {
        return $this->titreIllustration;
    }

    public function setTitreIllustration(?string $titreIllustration): self
    {
        $this->titreIllustration = $titreIllustration;

        return $this;
    }

    public function getLegendeIllustration(): ?string
    {
        return $this->legendeIllustration;
    }

    public function setLegendeIllustration(?string $legendeIllustration): self
    {
        $this->legendeIllustration = $legendeIllustration;

        return $this;
    }
}
