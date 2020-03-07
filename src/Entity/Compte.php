<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 * normalizationContext={"groups"={"read"}},
 * denormalizationContext={"groups"={"write"}}
 * )
 * 
 * @ORM\Entity(repositoryClass="App\Repository\CompteRepository")
 */
class Compte
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="integer")
     */
    private $numCompte;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="integer")
     */
    private $solde;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="date")
     */
    private $datecreation;



    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="comptes")
     */
    private $partenaires_c;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Depot", mappedBy="compte")
     */
    private $depots;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comptes")
     */
    private $users_createur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AffectationCompte", mappedBy="compte_affecté")
     */
    private $affectation_compte;

    public function __construct()
    {
        $this->depots = new ArrayCollection();
        $this->affectation_compte = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumCompte(): ?int
    {
        return $this->numCompte;
    }

    public function setNumCompte(int $numCompte): self
    {
        $this->numCompte = $numCompte;

        return $this;
    }

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(int $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getDatecreation(): ?\DateTimeInterface
    {
        return $this->datecreation;
    }

    public function setDatecreation(\DateTimeInterface $datecreation): self
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    public function getUserCreateur(): ?string
    {
        return $this->userCreateur;
    }

    public function setUserCreateur(User $userCreateur): self
    {
        $this->userCreateur = $userCreateur;

        return $this;
    }

    public function getPartenairesC(): ?Partenaire
    {
        return $this->partenaires_c;
    }

    public function setPartenairesC(?Partenaire $partenaires_c): self
    {
        $this->partenaires_c = $partenaires_c;

        return $this;
    }

    /**
     * @return Collection|Depot[]
     */
    public function getDepots(): Collection
    {
        return $this->depots;
    }

    public function addDepot(Depot $depot): self
    {
        if (!$this->depots->contains($depot)) {
            $this->depots[] = $depot;
            $depot->setCompte($this);
        }

        return $this;
    }

    public function removeDepot(Depot $depot): self
    {
        if ($this->depots->contains($depot)) {
            $this->depots->removeElement($depot);
            // set the owning side to null (unless already changed)
            if ($depot->getCompte() === $this) {
                $depot->setCompte(null);
            }
        }

        return $this;
    }

    public function getUsersCreateur(): ?User
    {
        return $this->users_createur;
    }

    public function setUsersCreateur(?User $users_createur): self
    {
        $this->users_createur = $users_createur;

        return $this;
    }

    /**
     * @return Collection|AffectationCompte[]
     */
    public function getAffectationCompte(): Collection
    {
        return $this->affectation_compte;
    }

    public function addAffectationCompte(AffectationCompte $affectationCompte): self
    {
        if (!$this->affectation_compte->contains($affectationCompte)) {
            $this->affectation_compte[] = $affectationCompte;
            $affectationCompte->setCompteAffecté($this);
        }

        return $this;
    }

    public function removeAffectationCompte(AffectationCompte $affectationCompte): self
    {
        if ($this->affectation_compte->contains($affectationCompte)) {
            $this->affectation_compte->removeElement($affectationCompte);
            // set the owning side to null (unless already changed)
            if ($affectationCompte->getCompteAffecté() === $this) {
                $affectationCompte->setCompteAffecté(null);
            }
        }

        return $this;
    }
}
