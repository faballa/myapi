<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 *  @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\PartenaireRepository")
 */
class Partenaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255)
     */
    private $regiecommerce;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255)
     */
    private $ninea;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Compte", mappedBy="Partenaires_c")
     */
    private $comptes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="partenaire")
     */
    private $admin_partenaire;

   


    public function __construct()
    {
        $this->comptes = new ArrayCollection();
        $this->admin_partenaire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegiecommerce(): ?string
    {
        return $this->regiecommerce;
    }

    public function setRegiecommerce(string $regiecommerce): self
    {
        $this->regiecommerce = $regiecommerce;

        return $this;
    }

    public function getNinea(): ?string
    {
        return $this->ninea;
    }

    public function setNinea(string $ninea): self
    {
        $this->ninea = $ninea;

        return $this;
    }

    /**
     * @return Collection|Compte[]
     */
    public function getComptes(): Collection
    {
        return $this->comptes;
    }

    public function addCompte(Compte $compte): self
    {
        if (!$this->comptes->contains($compte)) {
            $this->comptes[] = $compte;
            $compte->setPartenairesC($this);
        }

        return $this;
    }

    public function removeCompte(Compte $compte): self
    {
        if ($this->comptes->contains($compte)) {
            $this->comptes->removeElement($compte);
            // set the owning side to null (unless already changed)
            if ($compte->getPartenairesC() === $this) {
                $compte->setPartenairesC(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getAdminPartenaire(): Collection
    {
        return $this->admin_partenaire;
    }

    public function addAdminPartenaire(User $adminPartenaire): self
    {
        if (!$this->admin_partenaire->contains($adminPartenaire)) {
            $this->admin_partenaire[] = $adminPartenaire;
            $adminPartenaire->setPartenaire($this);
        }

        return $this;
    }

    public function removeAdminPartenaire(User $adminPartenaire): self
    {
        if ($this->admin_partenaire->contains($adminPartenaire)) {
            $this->admin_partenaire->removeElement($adminPartenaire);
            // set the owning side to null (unless already changed)
            if ($adminPartenaire->getPartenaire() === $this) {
                $adminPartenaire->setPartenaire(null);
            }
        }

        return $this;
    }

  

    
}
