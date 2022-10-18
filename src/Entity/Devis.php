<?php

namespace App\Entity;

use App\Repository\DevisRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DevisRepository::class)]
class Devis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reference = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_redaction = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $duree_validite = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $detail = null;

    #[ORM\Column(nullable: true)]
    private ?int $prix_ht = null;

    #[ORM\Column(nullable: true)]
    private ?int $prix_ttc = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $raison_social = null;

    #[ORM\ManyToOne(inversedBy: 'devis')]
    private ?Address $adresse = null;

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

    public function getPrixHt(): ?int
    {
        return $this->prix_ht;
    }

    public function setPrixHt(?int $prix_ht): self
    {
        $this->prix_ht = $prix_ht;

        return $this;
    }

    public function getPrixTtc(): ?int
    {
        return $this->prix_ttc;
    }

    public function setPrixTtc(?int $prix_ttc): self
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
}