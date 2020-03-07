<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\AffectationCompteRepository")
 */
class AffectationCompte
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dateFin;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="affectation_user")
     */
    private $user_trans;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="affectation_compte")
     */
    private $compte_affecté;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?string
    {
        return $this->dateDebut;
    }

    public function setDateDebut(string $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?string
    {
        return $this->dateFin;
    }

    public function setDateFin(string $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getUserTrans(): ?User
    {
        return $this->user_trans;
    }

    public function setUserTrans(?User $user_trans): self
    {
        $this->user_trans = $user_trans;

        return $this;
    }

    public function getCompteAffecté(): ?Compte
    {
        return $this->compte_affecté;
    }

    public function setCompteAffecté(?Compte $compte_affecté): self
    {
        $this->compte_affecté = $compte_affecté;

        return $this;
    }
}
