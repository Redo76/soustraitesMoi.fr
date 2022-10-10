<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProjectLogoRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ProjectLogoRepository::class)]
class ProjectLogo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 75, nullable: true)]
    private ?string $brand_name = null;

    #[ORM\Column(length: 75, nullable: true)]
    private ?string $activity = null;

    #[ORM\Column(length: 50)]
    private ?string $budget = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable:true)]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $explanation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $desired_colors = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $unwanted_colors = null;

    #[ORM\OneToMany(mappedBy: 'projectLogo', targetEntity: Image::class, cascade: ['persist', 'remove'])]
    private Collection $good_logo_example;

    #[ORM\OneToMany(mappedBy: 'badProjectLogo', targetEntity: Image::class, cascade: ['persist', 'remove'])]
    private Collection $bad_logo_example;

    #[ORM\Column(length: 75, nullable: true)]
    private ?string $other_brands = null;

    #[ORM\Column(length: 75, nullable: true)]
    private ?string $support = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?bool $creation = null;

    #[ORM\Column(length: 75, nullable: true)]
    private ?string $img_format = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?bool $background = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $user = null;

    public function __construct($user)
    {
        $this->user = $user;
        $this->good_logo_example = new ArrayCollection();
        $this->bad_logo_example = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getExplanation(): ?string
    {
        return $this->explanation;
    }

    public function setExplanation(string $explanation): self
    {
        $this->explanation = $explanation;

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

    public function getUnwantedColors(): ?string
    {
        return $this->unwanted_colors;
    }

    public function setUnwantedColors(?string $unwanted_colors): self
    {
        $this->unwanted_colors = $unwanted_colors;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getGoodLogoExample(): Collection
    {
        return $this->good_logo_example;
    }

    public function addGoodLogoExample(Image $goodLogoExample): self
    {
        if (!$this->good_logo_example->contains($goodLogoExample)) {
            $this->good_logo_example->add($goodLogoExample);
            $goodLogoExample->setGoodProjectLogo($this);
        }

        return $this;
    }

    public function removeGoodLogoExample(Image $goodLogoExample): self
    {
        if ($this->good_logo_example->removeElement($goodLogoExample)) {
            // set the owning side to null (unless already changed)
            if ($goodLogoExample->getGoodProjectLogo() === $this) {
                $goodLogoExample->setGoodProjectLogo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getBadLogoExample(): Collection
    {
        return $this->bad_logo_example;
    }

    public function addBadLogoExample(Image $badLogoExample): self
    {
        if (!$this->bad_logo_example->contains($badLogoExample)) {
            $this->bad_logo_example->add($badLogoExample);
            $badLogoExample->setBadProjectLogo($this);
        }

        return $this;
    }

    public function removeBadLogoExample(Image $badLogoExample): self
    {
        if ($this->bad_logo_example->removeElement($badLogoExample)) {
            // set the owning side to null (unless already changed)
            if ($badLogoExample->getBadProjectLogo() === $this) {
                $badLogoExample->setBadProjectLogo(null);
            }
        }

        return $this;
    }

    public function getOtherBrands(): ?string
    {
        return $this->other_brands;
    }

    public function setOtherBrands(?string $other_brands): self
    {
        $this->other_brands = $other_brands;

        return $this;
    }

    public function getSupport(): ?string
    {
        return $this->support;
    }

    public function setSupport(?string $support): self
    {
        $this->support = $support;

        return $this;
    }

    public function getCreation(): ?string
    {
        return $this->creation;
    }

    public function setCreation(?string $creation): self
    {
        $this->creation = $creation;

        return $this;
    }

    public function getImgFormat(): ?string
    {
        return $this->img_format;
    }

    public function setImgFormat(?string $img_format): self
    {
        $this->img_format = $img_format;

        return $this;
    }

    public function getBackground(): ?string
    {
        return $this->background;
    }

    public function setBackground(?string $background): self
    {
        $this->background = $background;

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
}
