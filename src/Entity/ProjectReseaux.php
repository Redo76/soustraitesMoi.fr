<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use App\Repository\ProjectReseauxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ProjectReseauxRepository::class)]
// #[UniqueEntity(fields: ['Nom_du_projet'], message: 'Il existe déjà un projet portant ce nom')]
class ProjectReseaux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\ManyToOne(inversedBy: 'projectReseaux')]
    private ?User $user = null;
    

    #[ORM\Column(length: 75)]
    private ?string $Nom_du_projet = null;

    #[ORM\Column(length: 75, nullable: true)]
    private ?string $activity = null;

    #[ORM\Column(length: 50)]
    private ?string $budget = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $mission_duration = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $publication = null;
    
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $website = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $location = null;

    #[ORM\OneToMany(mappedBy: 'projectReseauxLogo', targetEntity: Image::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $logo;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $snapchat = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tiktok = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $instagram = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $facebook = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $linkedin = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $twitter = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pinterest = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $other_media = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $community_manager = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $impact = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $desired_colors = null;


    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $liked_example = null;

    #[ORM\OneToMany(mappedBy: 'example', targetEntity: Image::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $example;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?bool $statut = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $price = null;

    #[ORM\OneToMany(mappedBy: 'projet_reseaux', targetEntity: Devis::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $devis;

    public function __construct($user)
    {
        $this->user = $user;
        $this->logo = new ArrayCollection();
        $this->example = new ArrayCollection();
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

    public function getActivity(): ?string
    {
        return $this->activity;
    }

    public function setActivity(?string $activity): self
    {
        $this->activity = $activity;

        return $this;
    }

    public function getBudget(): ?string
    {
        return $this->budget;
    }

    public function setBudget(string $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(?\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getMissionDuration(): ?string
    {
        return $this->mission_duration;
    }

    public function setMissionDuration(?string $mission_duration): self
    {
        $this->mission_duration = $mission_duration;

        return $this;
    }

    public function getPublication(): ?string
    {
        return $this->publication;
    }

    public function setPublication(?string $publication): self
    {
        $this->publication = $publication;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getLogo(): Collection
    {
        return $this->logo;
    }

    public function addLogo(Image $logo): self
    {
        if (!$this->logo->contains($logo)) {
            $this->logo->add($logo);
            $logo->setProjectReseauxLogo($this);
        }

        return $this;
    }

    public function removeLogo(Image $logo): self
    {
        if ($this->logo->removeElement($logo)) {
            // set the owning side to null (unless already changed)
            if ($logo->getProjectReseauxLogo() === $this) {
                $logo->setProjectReseauxLogo(null);
            }
        }

        return $this;
    }

    public function getSnapchat(): ?string
    {
        return $this->snapchat;
    }

    public function setSnapchat(?string $snapchat): self
    {
        $this->snapchat = $snapchat;

        return $this;
    }

    public function getTiktok(): ?string
    {
        return $this->tiktok;
    }

    public function setTiktok(?string $tiktok): self
    {
        $this->tiktok = $tiktok;

        return $this;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): self
    {
        $this->instagram = $instagram;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getLinkedin(): ?string
    {
        return $this->linkedin;
    }

    public function setLinkedin(?string $linkedin): self
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getPinterest(): ?string
    {
        return $this->pinterest;
    }

    public function setPinterest(?string $pinterest): self
    {
        $this->pinterest = $pinterest;

        return $this;
    }

    public function getOtherMedia(): ?string
    {
        return $this->other_media;
    }

    public function setOtherMedia(?string $other_media): self
    {
        $this->other_media = $other_media;

        return $this;
    }

    public function getCommunityManager(): ?string
    {
        return $this->community_manager;
    }

    public function setCommunityManager(?string $community_manager): self
    {
        $this->community_manager = $community_manager;

        return $this;
    }

    public function getImpact(): ?string
    {
        return $this->impact;
    }

    public function setImpact(?string $impact): self
    {
        $this->impact = $impact;

        return $this;
    }

    public function getDesiredColors(): ?string
    {
        return $this->desired_colors;
    }

    public function setDesiredColors(?string $desired_colors): self
    {
        $this->desired_colors = $desired_colors;

        return $this;
    }

    public function getLikedExample(): ?string
    {
        return $this->liked_example;
    }

    public function setLikedExample(?string $liked_example): self
    {
        $this->liked_example = $liked_example;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

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
    public function getExample(): Collection
    {
        return $this->example;
    }

    public function addExample(Image $example): self
    {
        if (!$this->example->contains($example)) {
            $this->example->add($example);
            $example->setExample($this);
        }

        return $this;
    }

    public function removeExample(Image $example): self
    {
        if ($this->example->removeElement($example)) {
            // set the owning side to null (unless already changed)
            if ($example->getExample() === $this) {
                $example->setExample(null);
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

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(?bool $statut): self
    {
        $this->statut = $statut;

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
            $devi->setProjetReseaux($this);
        }

        return $this;
    }

    public function removeDevi(Devis $devi): self
    {
        if ($this->devis->removeElement($devi)) {
            // set the owning side to null (unless already changed)
            if ($devi->getProjetReseaux() === $this) {
                $devi->setProjetReseaux(null);
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
}
