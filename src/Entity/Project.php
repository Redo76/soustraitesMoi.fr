<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;



#[ORM\Entity(repositoryClass: ProjectRepository::class)]
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

    #[ORM\Column(length: 75, nullable: true)]
    private ?string $Statut = null;

    #[ORM\ManyToOne(inversedBy: 'projects')]
    // LIER USER/PROJECT
    // pour que la colonne user_id dans la table project ne puisse pas être nulle
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    // LIER USER/PROJECT
    // à mettre pour que chaque nouveau projet soit rattaché au user connecté
    public function __construct($user)
    {
        $this->User = $user;
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

    public function getStatut(): ?string
    {
        return $this->Statut;
    }

    public function setStatut(?string $Statut): self
    {
        $this->Statut = $Statut;

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
}
