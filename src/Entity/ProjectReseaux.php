<?php

namespace App\Entity;

use App\Repository\ProjectReseauxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectReseauxRepository::class)]
class ProjectReseaux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?User $user = null;
    
    #[ORM\Column(length: 75, nullable: true)]
    private ?string $brand_name = null;

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

    #[ORM\OneToMany(mappedBy: 'projectReseaux', targetEntity: Image::class, cascade: ['persist', 'remove'])]
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

    #[ORM\OneToMany(mappedBy: 'projectReseaux', targetEntity: Image::class, cascade: ['persist', 'remove'])]
    private Collection $example;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $liked_example = null;

    public function __construct($user)
    {
        $this->user = $user;
        $this->logo = new ArrayCollection();
        $this->example = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
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

    public function getBrandName(): ?string
    {
        return $this->brand_name;
    }

    public function setBrandName(?string $brand_name): self
    {
        $this->brand_name = $brand_name;

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
            $logo->setProjectReseaux($this);
        }

        return $this;
    }

    public function removeLogo(Image $logo): self
    {
        if ($this->logo->removeElement($logo)) {
            // set the owning side to null (unless already changed)
            if ($logo->getProjectReseaux() === $this) {
                $logo->setProjectReseaux(null);
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
            $example->setProjectReseaux($this);
        }

        return $this;
    }

    public function removeExample(Image $example): self
    {
        if ($this->example->removeElement($example)) {
            // set the owning side to null (unless already changed)
            if ($example->getProjectReseaux() === $this) {
                $example->setProjectReseaux(null);
            }
        }

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
}
