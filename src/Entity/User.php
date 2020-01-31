<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * @ApiResource()
 * collectionOperations={
 *          "get"={"security"="is_granted(['ROLE_ADMIN_SYSTEM','ROLE_ADMIN'])",
 *           "security_message"="Acces refuse. Seul Admin System ou Admin peut lister les elements d'une ressource",
 *            "normalisation_context"={"groups"={"get"}},
 *         },
 *          "createAdmin"={
 *          "method"="POST",
 *          "path"="/users/admin/new",
 *              "security"="is_granted('ROLE_ADMIN_SYSTEM')", 
 *               "security_message"="Acces refuse. Seul Admin System peut creer un Admin "
 *                 },
 *         "createCaissier"={
 *          "method"="POST",
 *          "path"="/users/caissier/new",
 *              "security"="is_granted(['ROLE_ADMIN'])", 
 *              "security_message"="Acces refuse. Seul Admin System ou Admin peut creer un  Caissier"
 *                 }
 *             },
 *     itemOperations={
 *          "get"={
 *   "security"="is_granted(['ROLE_ADMIN'])",
 *     "security_message"="Acces refuse. Seul Admin System ou Admin peut lister un element d'une ressource",
 *             "normalisation_context"={"groups"={"get"}}
 *              },
 *          "blockedAdmin"={
 *               "method"="PUT",
 *               "path"="/users/admin/{id}",
 *              "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Acces refuse. Seul Admin System peut bloquer un Admin "
 *                   },
 *         "blockedCaissier"={
 *               "method"="PUT",
 *               "path"="/users/caissier/{id}",
 *              "security"="is_granted(['ROLE_ADMIN'])",
 *          "security_message"="Acces refuse. Seul Admin System ou Admin peut bloquer un Caissier"
 *                   },
 *          "delete"={"security"="is_granted('ROLE_ADMIN_SYSTEM')",
 *          "security_message"="Acces Refuse. Seul le Super Admin peut supprimer un User"
 *                  
 *                }
 *     }
 *   
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements AdvancedUserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @Groups({"read", "write"})
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Role", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $role;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="admin_partenaire")
     */
    private $partenaire;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Compte", mappedBy="users_createur")
     */
    private $comptes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Depot", mappedBy="users_createurd")
     */
    private $depots;

    public function __construct()
    {
        $this->comptes = new ArrayCollection();
        $this->depots = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles = $this->roles;

        return $roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
    public function isAccountNonExpired()
    {
        return true;
    }
    public function isAccountNonLocked()
    {
        return true;
    }
    public function isCredentialsNonExpired()
    {
        return true;
    }
    public function isEnabled()
    {
        return $this->isActive;
    }

    public function getPartenaire(): ?Partenaire
    {
        return $this->partenaire;
    }

    public function setPartenaire(?Partenaire $partenaire): self
    {
        $this->partenaire = $partenaire;

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
            $compte->setUsersCreateur($this);
        }

        return $this;
    }

    public function removeCompte(Compte $compte): self
    {
        if ($this->comptes->contains($compte)) {
            $this->comptes->removeElement($compte);
            // set the owning side to null (unless already changed)
            if ($compte->getUsersCreateur() === $this) {
                $compte->setUsersCreateur(null);
            }
        }

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
            $depot->setUsersCreateurd($this);
        }

        return $this;
    }

    public function removeDepot(Depot $depot): self
    {
        if ($this->depots->contains($depot)) {
            $this->depots->removeElement($depot);
            // set the owning side to null (unless already changed)
            if ($depot->getUsersCreateurd() === $this) {
                $depot->setUsersCreateurd(null);
            }
        }

        return $this;
    }
}


