<?php

namespace App\Entity;

use App\Repository\TelephonesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TelephonesRepository::class)]
class Telephones
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 25)]
    private $numero;

    #[ORM\OneToMany(mappedBy: 'numero', targetEntity: Collaborateurs::class)]
    private $collaborateurs;


    public function __construct()
    {
        $this->collaborateurs = new ArrayCollection();
    }

    //correction could not be converted to string
    public function __toString()
    {
        return $this->numero;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

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
            $collaborateur->setNumero($this);
        }

        return $this;
    }

    public function removeCollaborateur(Collaborateurs $collaborateur): self
    {
        if ($this->collaborateurs->removeElement($collaborateur)) {
            // set the owning side to null (unless already changed)
            if ($collaborateur->getNumero() === $this) {
                $collaborateur->setNumero(null);
            }
        }

        return $this;
    }
}
