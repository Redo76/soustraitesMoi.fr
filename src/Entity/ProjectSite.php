<?php

namespace App\Entity;

use App\Repository\ProjectSiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectSiteRepository::class)]
class ProjectSite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'projectSites')]
    private ?User $user = null;

    #[ORM\Column(length: 75)]
    private ?string $Nom_du_projet = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $presentation = null;

    #[ORM\Column(length: 75, nullable: true)]
    private ?string $activity = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $offers = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $service = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $valeurs = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $main_objective = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $secondary_objective = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $profil_client = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $homepage = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $about = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $our_services = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $contact = null;
    
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $contact_form = null;
    
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $search_bar = null;
    
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $catalogue = null;
    
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $client = null;
    
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $newsletter = null;
    
    #[ORM\Column(length: 150, nullable: true)]
    private ?string $logo = null;

    #[ORM\OneToMany(mappedBy: 'logo_site', targetEntity: Image::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $logo_files;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $visuals = null;

    #[ORM\OneToMany(mappedBy: 'visuals', targetEntity: Image::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $visuals_files;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $typography = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $colors = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $loved_sites = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $other_site = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?bool $statut = null;

    public function __construct($user)
    {
        $this->user = $user;
        $this->visuals_files = new ArrayCollection();
        $this->logo_files = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable('now');
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

    public function getNomDuProjet(): ?string
    {
        return $this->Nom_du_projet;
    }

    public function setNomDuProjet(string $Nom_du_projet): self
    {
        $this->Nom_du_projet = $Nom_du_projet;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(?string $presentation): self
    {
        $this->presentation = $presentation;

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

    public function getOffers(): ?string
    {
        return $this->offers;
    }

    public function setOffers(?string $offers): self
    {
        $this->offers = $offers;

        return $this;
    }

    public function getService(): ?string
    {
        return $this->service;
    }

    public function setService(?string $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getValeurs(): ?string
    {
        return $this->valeurs;
    }

    public function setValeurs(?string $valeurs): self
    {
        $this->valeurs = $valeurs;

        return $this;
    }

    public function getMainObjective(): ?string
    {
        return $this->main_objective;
    }

    public function setMainObjective(?string $main_objective): self
    {
        $this->main_objective = $main_objective;

        return $this;
    }

    public function getSecondaryObjective(): ?string
    {
        return $this->secondary_objective;
    }

    public function setSecondaryObjective(?string $secondary_objective): self
    {
        $this->secondary_objective = $secondary_objective;

        return $this;
    }

    public function getProfilClient(): ?string
    {
        return $this->profil_client;
    }

    public function setProfilClient(?string $profil_client): self
    {
        $this->profil_client = $profil_client;

        return $this;
    }

    public function getHomepage(): ?string
    {
        return $this->homepage;
    }

    public function setHomepage(?string $homepage): self
    {
        $this->homepage = $homepage;

        return $this;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function setAbout(?string $about): self
    {
        $this->about = $about;

        return $this;
    }

    public function getOurServices(): ?string
    {
        return $this->our_services;
    }

    public function setOurServices(?string $our_services): self
    {
        $this->our_services = $our_services;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(?string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getContactForm(): ?string
    {
        return $this->contact_form;
    }

    public function setContactForm(?string $contact_form): self
    {
        $this->contact_form = $contact_form;

        return $this;
    }

    public function getSearchBar(): ?string
    {
        return $this->search_bar;
    }

    public function setSearchBar(?string $search_bar): self
    {
        $this->search_bar = $search_bar;

        return $this;
    }

    public function getCatalogue(): ?string
    {
        return $this->catalogue;
    }

    public function setCatalogue(?string $catalogue): self
    {
        $this->catalogue = $catalogue;

        return $this;
    }

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient(?string $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getNewsletter(): ?string
    {
        return $this->newsletter;
    }

    public function setNewsletter(?string $newsletter): self
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    public function getVisuals(): ?string
    {
        return $this->visuals;
    }

    public function setVisuals(?string $visuals): self
    {
        $this->visuals = $visuals;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getVisualsFiles(): Collection
    {
        return $this->visuals_files;
    }

    public function addVisualsFile(Image $visualsFile): self
    {
        if (!$this->visuals_files->contains($visualsFile)) {
            $this->visuals_files->add($visualsFile);
            $visualsFile->setProjectSite($this);
        }

        return $this;
    }

    public function removeVisualsFile(Image $visualsFile): self
    {
        if ($this->visuals_files->removeElement($visualsFile)) {
            // set the owning side to null (unless already changed)
            if ($visualsFile->getProjectSite() === $this) {
                $visualsFile->setProjectSite(null);
            }
        }

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getTypography(): ?string
    {
        return $this->typography;
    }

    public function setTypography(?string $typography): self
    {
        $this->typography = $typography;

        return $this;
    }

    public function getColors(): ?string
    {
        return $this->colors;
    }

    public function setColors(?string $colors): self
    {
        $this->colors = $colors;

        return $this;
    }

    public function getLovedSites(): ?string
    {
        return $this->loved_sites;
    }

    public function setLovedSites(?string $loved_sites): self
    {
        $this->loved_sites = $loved_sites;

        return $this;
    }

    public function getOtherSite(): ?string
    {
        return $this->other_site;
    }

    public function setOtherSite(?string $other_site): self
    {
        $this->other_site = $other_site;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getLogoFiles(): Collection
    {
        return $this->logo_files;
    }

    public function addLogoFile(Image $logoFile): self
    {
        if (!$this->logo_files->contains($logoFile)) {
            $this->logo_files->add($logoFile);
            $logoFile->setProjectSite($this);
        }

        return $this;
    }

    public function removeLogoFile(Image $logoFile): self
    {
        if ($this->logo_files->removeElement($logoFile)) {
            // set the owning side to null (unless already changed)
            if ($logoFile->getProjectSite() === $this) {
                $logoFile->setProjectSite(null);
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
}
