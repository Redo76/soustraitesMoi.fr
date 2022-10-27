<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?Project $project = null;

    #[ORM\ManyToOne(inversedBy: 'good_logo_example')]
    private ?ProjectLogo $goodProjectLogo = null;

    #[ORM\ManyToOne(inversedBy: 'bad_logo_example')]
    private ?ProjectLogo $badProjectLogo = null;

    #[ORM\ManyToOne(inversedBy: 'logo')]
    private ?ProjectReseaux $projectReseauxLogo = null;

    #[ORM\ManyToOne(inversedBy: 'example')]
    private ?ProjectReseaux $example = null;
    
    #[ORM\ManyToOne(inversedBy: 'visuals_files')]
    private ?ProjectSite $visuals = null;

    #[ORM\ManyToOne(inversedBy: 'logo_files')]
    private ?ProjectSite $logo_site = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?Devis $devis = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function getGoodProjectLogo(): ?ProjectLogo
    {
        return $this->goodProjectLogo;
    }

    public function setGoodProjectLogo(?ProjectLogo $goodProjectLogo): self
    {
        $this->goodProjectLogo = $goodProjectLogo;

        return $this;
    }

    public function getBadProjectLogo(): ?ProjectLogo
    {
        return $this->badProjectLogo;
    }

    public function setBadProjectLogo(?ProjectLogo $badProjectLogo): self
    {
        $this->badProjectLogo = $badProjectLogo;

        return $this;
    }

    public function getProjectReseauxLogo(): ?ProjectReseaux
    {
        return $this->projectReseauxLogo;
    }

    public function setProjectReseauxLogo(?ProjectReseaux $projectReseauxLogo): self
    {
        $this->projectReseauxLogo = $projectReseauxLogo;

        return $this;
    }

    public function getExample(): ?ProjectReseaux
    {
        return $this->example;
    }

    public function setExample(?ProjectReseaux $example): self
    {
        $this->example = $example;

        return $this;
    }
    
    public function getVisuals(): ?ProjectSite
    {
        return $this->visuals;
    }

    public function setVisuals(?ProjectSite $visuals): self
    {
        $this->visuals = $visuals;

        return $this;
    }
    
    public function getLogoSite(): ?ProjectSite
    {
        return $this->logo_site;
    }

    public function setLogoSite(?ProjectSite $logo_site): self
    {
        $this->logo_site = $logo_site;

        return $this;
    }

    public function getDevis(): ?Devis
    {
        return $this->devis;
    }

    public function setDevis(?Devis $devis): self
    {
        $this->devis = $devis;

        return $this;
    }
}
