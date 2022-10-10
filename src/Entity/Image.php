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
    private ?ProjectLogo $goodprojectLogo = null;

    #[ORM\ManyToOne(inversedBy: 'bad_logo_example')]
    private ?ProjectLogo $badProjectLogo = null;

    #[ORM\ManyToOne(inversedBy: 'logo')]
    private ?ProjectReseaux $projectReseaux = null;

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

    public function getProjectReseaux(): ?ProjectReseaux
    {
        return $this->projectReseaux;
    }

    public function setProjectReseaux(?ProjectReseaux $projectReseaux): self
    {
        $this->projectReseaux = $projectReseaux;

        return $this;
    }
}
