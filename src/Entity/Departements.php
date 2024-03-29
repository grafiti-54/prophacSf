<?php

namespace App\Entity;

use App\Repository\DepartementsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: DepartementsRepository::class)]
class Departements
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 150)]
    private $nom;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private $logo;

    #[ORM\ManyToMany(targetEntity: Collaborateurs::class, inversedBy: 'departements')]
    private $collaborateur;

    #[ORM\ManyToMany(targetEntity: Produits::class, mappedBy: 'departement')]
    // #[ORM\JoinTable(name: "Produits")]
    // #[ORM\JoinColumn(name: "id")]
    private $produit;

    #[ORM\ManyToMany(targetEntity: Partenaires::class, mappedBy: 'departement')]
    private $partenaires;

    #[ORM\OneToMany(mappedBy: 'departement', targetEntity: Articles::class)]
    private $articles;

    public function __construct()
    {
        $this->collaborateur = new ArrayCollection();
        $this->produit = new ArrayCollection();
        $this->partenaires = new ArrayCollection();
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * @return Collection<int, Collaborateurs>
     */
    public function getCollaborateur(): Collection
    {
        return $this->collaborateur;
    }

    public function addCollaborateur(Collaborateurs $collaborateur): self
    {
        if (!$this->collaborateur->contains($collaborateur)) {
            $this->collaborateur[] = $collaborateur;
        }

        return $this;
    }

    public function removeCollaborateur(Collaborateurs $collaborateur): self
    {
        $this->collaborateur->removeElement($collaborateur);

        return $this;
    }

    /**
     * @return Collection<int, Produits>
     */
    public function getProduit(): Collection
    {
        return $this->produit;
    }

    public function addProduit(Produits $produit): self
    {
        if (!$this->produit->contains($produit)) {
            $this->produit[] = $produit;
            $produit->addDepartement($this);
        }

        return $this;
    }

    public function removeProduit(Produits $produit): self
    {
        if ($this->produit->removeElement($produit)) {
            $produit->removeDepartement($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Partenaires>
     */
    public function getPartenaires(): Collection
    {
        return $this->partenaires;
    }

    public function addPartenaire(Partenaires $partenaire): self
    {
        if (!$this->partenaires->contains($partenaire)) {
            $this->partenaires[] = $partenaire;
            $partenaire->addDepartement($this);
        }

        return $this;
    }

    public function removePartenaire(Partenaires $partenaire): self
    {
        if ($this->partenaires->removeElement($partenaire)) {
            $partenaire->removeDepartement($this);
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
            $article->setDepartement($this);
        }

        return $this;
    }

    public function removeArticle(Articles $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getDepartement() === $this) {
                $article->setDepartement(null);
            }
        }

        return $this;
    }

    // public function voirProduit(ManagerRegistry $doctrine):Response
    // {
    //     $produit = $doctrine->getRepository(Produits::class)->findAll();

    //     $departement = $produit->getNom();

    //     return $this;
    // }
}
