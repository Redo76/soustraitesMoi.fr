<?php

namespace App\Entity;

use App\Repository\DevisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DevisRepository::class)]
class Devis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 75, nullable: true)]
    private ?string $reference = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_redaction = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $duree_validite = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $detail = null;

    #[ORM\Column(nullable: true)]
    private ?string $prix_ht = null;

    #[ORM\Column(nullable: true)]
    private ?string $prix_ttc = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $raison_social = null;

    #[ORM\ManyToOne(inversedBy: 'devis',cascade: ['persist', 'remove'])]
    private ?Address $adresse = null;

    #[ORM\Column(length: 14, nullable: true)]
    private ?string $siret = null;

    #[ORM\ManyToOne(inversedBy: 'devis')]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'devis', targetEntity: Image::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $images;

    #[ORM\ManyToOne(inversedBy: 'devis')]
    private ?Project $projet_libre = null;

    #[ORM\ManyToOne(inversedBy: 'devis')]
    private ?ProjectLogo $projet_logo = null;

    #[ORM\ManyToOne(inversedBy: 'devis')]
    private ?ProjectReseaux $projet_reseaux = null;

    #[ORM\ManyToOne(inversedBy: 'devis')]
    private ?ProjectSite $projet_site = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $created_at = null;

    public function __construct($user)
    {
        $this->user = $user;
        $this->images = new ArrayCollection();
        $this->created_at = new \DateTimeImmutable('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getDateRedaction(): ?\DateTimeInterface
    {
        return $this->date_redaction;
    }

    public function setDateRedaction(?\DateTimeInterface $date_redaction): self
    {
        $this->date_redaction = $date_redaction;

        return $this;
    }

    public function getDureeValidite(): ?\DateTimeInterface
    {
        return $this->duree_validite;
    }

    public function setDureeValidite(?\DateTimeInterface $duree_validite): self
    {
        $this->duree_validite = $duree_validite;

        return $this;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(?string $detail): self
    {
        $this->detail = $detail;

        return $this;
    }

    public function getPrixHt(): ?string
    {
        return $this->prix_ht;
    }

    public function setPrixHt(?string $prix_ht): self
    {
        $this->prix_ht = $prix_ht;

        return $this;
    }

    public function getPrixTtc(): ?string
    {
        return $this->prix_ttc;
    }

    public function setPrixTtc(?string $prix_ttc): self
    {
        $this->prix_ttc = $prix_ttc;

        return $this;
    }

    public function getRaisonSocial(): ?string
    {
        return $this->raison_social;
    }

    public function setRaisonSocial(?string $raison_social): self
    {
        $this->raison_social = $raison_social;

        return $this;
    }

    public function getAdresse(): ?Address
    {
        return $this->adresse;
    }

    public function setAdresse(?Address $adresse): self
    {
        $this->adresse = $adresse;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
            $image->setDevis($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getDevis() === $this) {
                $image->setDevis(null);
            }
        }

        return $this;
    }

    public function getProjetLibre(): ?Project
    {
        return $this->projet_libre;
    }

    public function setProjetLibre(?Project $projet_libre): self
    {
        $this->projet_libre = $projet_libre;

        return $this;
    }

    public function getProjetLogo(): ?ProjectLogo
    {
        return $this->projet_logo;
    }

    public function setProjetLogo(?ProjectLogo $projet_logo): self
    {
        $this->projet_logo = $projet_logo;

        return $this;
    }

    public function getProjetReseaux(): ?ProjectReseaux
    {
        return $this->projet_reseaux;
    }

    public function setProjetReseaux(?ProjectReseaux $projet_reseaux): self
    {
        $this->projet_reseaux = $projet_reseaux;

        return $this;
    }

    public function getProjetSite(): ?ProjectSite
    {
        return $this->projet_site;
    }

    public function setProjetSite(?ProjectSite $projet_site): self
    {
        $this->projet_site = $projet_site;

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
}
