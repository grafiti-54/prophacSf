<?php

namespace App\Entity;

use App\Repository\QualificationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QualificationsRepository::class)]
class Qualifications
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 80)]
    private $libelle;

    #[ORM\ManyToMany(targetEntity: Collaborateurs::class, mappedBy: 'qualification')]
    private $collaborateurs;

    public function __construct()
    {
        $this->collaborateurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Collaborateurs>
     */
    public function getCollaborateurs(): Collection
    {
        return $this->collaborateurs;
    }

    public function addCollaborateur(Collaborateurs $collaborateur): self
    {
        if (!$this->collaborateurs->contains($collaborateur)) {
            $this->collaborateurs[] = $collaborateur;
            $collaborateur->addQualification($this);
        }

        return $this;
    }

    public function removeCollaborateur(Collaborateurs $collaborateur): self
    {
        if ($this->collaborateurs->removeElement($collaborateur)) {
            $collaborateur->removeQualification($this);
        }

        return $this;
    }
}
