<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 100, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $telephone = null;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Emprunt::class, cascade: ['persist', 'remove'])]
    private Collection $historiqueEmprunts;

    public function __construct()
    {
        $this->historiqueEmprunts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;
        return $this;
    }

    /**
     * @return Collection<int, Emprunt>
     */
    public function getHistoriqueEmprunts(): Collection
    {
        return $this->historiqueEmprunts;
    }

    public function addHistoriqueEmprunt(Emprunt $emprunt): static
    {
        if (!$this->historiqueEmprunts->contains($emprunt)) {
            $this->historiqueEmprunts[] = $emprunt;
            $emprunt->setUtilisateur($this);
        }

        return $this;
    }

    public function removeHistoriqueEmprunt(Emprunt $emprunt): static
    {
        if ($this->historiqueEmprunts->removeElement($emprunt)) {
            // set the owning side to null (unless already changed)
            if ($emprunt->getUtilisateur() === $this) {
                $emprunt->setUtilisateur(null);
            }
        }

        return $this;
    }
}
