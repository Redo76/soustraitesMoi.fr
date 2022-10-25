<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'Il existe déjà un compte avec cet email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: Project::class, orphanRemoval: true)]
    private Collection $projects;

    #[ORM\Column(length: 75)]
    private ?string $firstName = null;

    #[ORM\Column(length: 75)]
    private ?string $lastName = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column(nullable: true)]
    private ?string $password = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $avatar = null;
    
    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $googleId = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Address $address = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $siret = null;

    #[ORM\Column(length: 75, nullable: true)]
    private ?string $companyName = null;

    #[ORM\Column(length: 180, nullable: true)]
    private ?string $companyCommercialName = null;
    
    #[ORM\Column(length: 75, nullable: true)]
    private ?string $jobInCompany = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isCompany = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ProjectLogo::class, orphanRemoval: true)]
    private Collection $projectLogos;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ProjectReseaux::class, orphanRemoval: true)]
    private Collection $projectReseaux;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ProjectSite::class, orphanRemoval: true)]
    private Collection $projectSites;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $resetToken = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Devis::class, orphanRemoval: true)]
    private Collection $devis;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $cv = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $created_at = null;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->projectLogos = new ArrayCollection();
        $this->projectReseaux = new ArrayCollection();
        $this->projectSites = new ArrayCollection();
        $this->devis = new ArrayCollection();
        $this->created_at = new \DateTimeImmutable('now');
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
            $project->setUser($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getUser() === $this) {
                $project->setUser(null);
            }
        }

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
    
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }
    public function getGoogleId(): ?string
    {
        return $this->googleId;
    }

    public function setGoogleId(?string $googleId): self
    {
        $this->googleId = $googleId;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(?string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getCompanyCommercialName(): ?string
    {
        return $this->companyCommercialName;
    }

    public function setCompanyCommercialName(?string $companyCommercialName): self
    {
        $this->companyCommercialName = $companyCommercialName;

        return $this;
    }

    public function isIsCompany(): ?bool
    {
        return $this->isCompany;
    }

    public function setIsCompany(bool $isCompany): self
    {
        $this->isCompany = $isCompany;

        return $this;
    }

    /**
     * @return Collection<int, ProjectReseaux>
     */
    public function getprojectReseaux(): Collection
    {
        return $this->projectReseaux;
    }

    public function addProjectReseaux(ProjectReseaux $projectReseaux): self
    {
        if (!$this->projectReseaux->contains($projectReseaux)) {
            $this->projectReseaux->add($projectReseaux);
            $projectReseaux->setUser($this);
        }

        return $this;
    }

    public function removeProjectReseaux(ProjectReseaux $projectReseaux): self
    {
        if ($this->projectReseaux->removeElement($projectReseaux)) {
            // set the owning side to null (unless already changed)
            if ($projectReseaux->getUser() === $this) {
                $projectReseaux->setUser(null);
            }
        }

        return $this;
    }

    public function getJobInCompany(): ?string
    {
        return $this->jobInCompany;
    }

    public function setJobInCompany(?string $jobInCompany): self
    {
        $this->jobInCompany = $jobInCompany;

        return $this;
    }

    /**
     * @return Collection<int, ProjectLogo>
     */
    public function getProjectLogos(): Collection
    {
        return $this->projectLogos;
    }

    public function addProjectLogo(ProjectLogo $projectLogo): self
    {
        if (!$this->projectLogos->contains($projectLogo)) {
            $this->projectLogos->add($projectLogo);
            $projectLogo->setUser($this);
        }

        return $this;
    }

    public function removeProjectLogo(ProjectLogo $projectLogo): self
    {
        if ($this->projectLogos->removeElement($projectLogo)) {
            // set the owning side to null (unless already changed)
            if ($projectLogo->getUser() === $this) {
                $projectLogo->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProjectSite>
     */
    public function getProjectSites(): Collection
    {
        return $this->projectSites;
    }

    public function addProjectSite(ProjectSite $projectSite): self
    {
        if (!$this->projectSites->contains($projectSite)) {
            $this->projectSites->add($projectSite);
            $projectSite->setUser($this);
        }

        return $this;
    }

    public function removeProjectSite(ProjectSite $projectSite): self
    {
        if ($this->projectSites->removeElement($projectSite)) {
            // set the owning side to null (unless already changed)
            if ($projectSite->getUser() === $this) {
                $projectSite->setUser(null);
            }
        }

        return $this;
    }

    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    public function setResetToken(?string $resetToken): self
    {
        $this->resetToken = $resetToken;

        return $this;
    }

    /**
     * @return Collection<int, Devis>
     */
    public function getDevis(): Collection
    {
        return $this->devis;
    }

    public function addDevi(Devis $devi): self
    {
        if (!$this->devis->contains($devi)) {
            $this->devis->add($devi);
            $devi->setUser($this);
        }

        return $this;
    }

    public function removeDevi(Devis $devi): self
    {
        if ($this->devis->removeElement($devi)) {
            // set the owning side to null (unless already changed)
            if ($devi->getUser() === $this) {
                $devi->setUser(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function setCv(?string $cv): self
    {
        $this->cv = $cv;

        return $this;
    }
}
