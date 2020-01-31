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
    private $NumCompte;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="integer")
     */
    private $solde;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="date")
     */
    private $Datecreation;



    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="comptes")
     */
    private $Partenaires_c;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Depot", mappedBy="compte")
     */
    private $depots;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comptes")
     */
    private $users_createur;

    public function __construct()
    {
        $this->depots = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumCompte(): ?int
    {
        return $this->NumCompte;
    }

    public function setNumCompte(int $NumCompte): self
    {
        $this->NumCompte = $NumCompte;

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
        return $this->Datecreation;
    }

    public function setDatecreation(\DateTimeInterface $Datecreation): self
    {
        $this->Datecreation = $Datecreation;

        return $this;
    }

    public function getUserCreateur(): ?string
    {
        return $this->UserCreateur;
    }

    public function setUserCreateur(string $UserCreateur): self
    {
        $this->UserCreateur = $UserCreateur;

        return $this;
    }

    public function getPartenairesC(): ?Partenaire
    {
        return $this->Partenaires_c;
    }

    public function setPartenairesC(?Partenaire $Partenaires_c): self
    {
        $this->Partenaires_c = $Partenaires_c;

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
}
