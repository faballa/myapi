<?php

namespace App\Entity;

use App\Entity\Compte;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DepotRepository")
 */
class Depot
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $NumCompte;

    /**
     * @ORM\Column(type="integer")
     */
    private $Solde;

    /**
     * @ORM\Column(type="date")
     */
    private $DateDepot;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="depots")
     */
    private $compte;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="depots")
     */
    private $users_createurd;

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
        return $this->Solde;
    }

    public function setSolde(int $Solde): self
    {
        $this->Solde = $Solde;

        return $this;
    }

    public function getDateDepot(): ?\DateTimeInterface
    {
        return $this->DateDepot;
    }

    public function setDateDepot(\DateTimeInterface $DateDepot): self
    {
        $this->DateDepot = $DateDepot;

        return $this;
    }

    public function getCompte(): ?Compte
    {
        return $this->compte;
    }

    public function setCompte(?Compte $compte): self
    {
        $this->compte = $compte;

        return $this;
    }

    public function getUsersCreateurd(): ?User
    {
        return $this->users_createurd;
    }

    public function setUsersCreateurd(?User $users_createurd): self
    {
        $this->users_createurd = $users_createurd;

        return $this;
    }
}
