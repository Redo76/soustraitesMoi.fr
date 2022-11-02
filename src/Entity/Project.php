<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


#[ORM\Entity(repositoryClass: ProjectRepository::class)]
// #[UniqueEntity(fields: ['Nom_du_projet'], message: 'Il existe déjà un projet portant ce nom')]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 75)]
    private ?string $Nom_du_projet = null;

    #[ORM\Column(length: 75)]
    private ?string $Categorie = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Description = null;

    #[ORM\Column(nullable: true)]
    private ?bool $statut = null;

    #[ORM\ManyToOne(inversedBy: 'projects')]
    // LIER USER/PROJECT
    // pour que la colonne user_id dans la table project ne puisse pas être nulle
    #[ORM\JoinColumn(nullable: true)]
    private ?User $User = null;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Image::class, cascade: ['persist', 'remove'])]
    private Collection $images;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $price = null;

    #[ORM\OneToMany(mappedBy: 'projet_libre', targetEntity: Devis::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $devis;

    #[ORM\Column(nullable: true)]
    private ?string $sessionId = null;

    // LIER USER/PROJECT
    // à mettre pour que chaque nouveau projet soit rattaché au user connecté
    public function __construct($user)
    {
        $this->User = $user;
        $this->images = new ArrayCollection();
        $this->created_at = new \DateTimeImmutable('now');
        $this->devis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDuProjet(): ?string
    {
        return $this->Nom_du_projet;
    }

    public function setNomDuProjet(string $Nom_du_projet): self
    {
        $this->Nom_du_projet = $Nom_du_projet;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->Categorie;
    }

    public function setCategorie(string $Categorie): self
    {
        $this->Categorie = $Categorie;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(?bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setProject($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProject() === $this) {
                $image->setProject(null);
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function isStatut(): ?bool
    {
        return $this->statut;
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
            $devi->setProjetLibre($this);
        }

        return $this;
    }

    public function removeDevi(Devis $devi): self
    {
        if ($this->devis->removeElement($devi)) {
            // set the owning side to null (unless already changed)
            if ($devi->getProjetLibre() === $this) {
                $devi->setProjetLibre(null);
            }
        }

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    public function setSessionId(?string $sessionId): self
    {
        $this->sessionId = $sessionId;

        return $this;
    }
}
