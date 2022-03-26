<?php

namespace App\Entity;

use App\Repository\ProduitsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[
    ORM\Entity(repositoryClass: ProduitsRepository::class),
    ORM\Table(name:"Produits"),
    ORM\Index(columns:["nom","description"], flags:["fulltext"])
]

class Produits
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 150)]
    private $nom;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private $photo;

    #[ORM\ManyToMany(targetEntity: Departements::class, inversedBy: 'produit')]
    // #[ORM\JoinTable(name: "Departements")]
    // #[ORM\JoinColumn(name: "id")]
    private $departement;

    #[ORM\ManyToOne(targetEntity: Partenaires::class, inversedBy: 'produits')]
    private $partenaire;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $lien;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $prioritaire;

    public function __construct()
    {
        $this->departement = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @return Collection<int, Departements>
     */
    public function getDepartement(): Collection
    {
        return $this->departement;
    }

    public function addDepartement(Departements $departement): self
    {
        if (!$this->departement->contains($departement)) {
            $this->departement[] = $departement;
        }

        return $this;
    }

    public function removeDepartement(Departements $departement): self
    {
        $this->departement->removeElement($departement);

        return $this;
    }

    public function getPartenaire(): ?Partenaires
    {
        return $this->partenaire;
    }

    public function setPartenaire(?Partenaires $partenaire): self
    {
        $this->partenaire = $partenaire;

        return $this;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(?string $lien): self
    {
        $this->lien = $lien;

        return $this;
    }

    public function getPrioritaire(): ?bool
    {
        return $this->prioritaire;
    }

    public function setPrioritaire(?bool $prioritaire): self
    {
        $this->prioritaire = $prioritaire;

        return $this;
    }
}
