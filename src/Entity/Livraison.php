<?php

namespace App\Entity;

use App\Repository\LivraisonRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $Date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $Heure = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Livreur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $Id): static
    {
        $this->Id = $Id;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(?\DateTimeInterface $Date): static
    {
        $this->Date = $Date;

        return $this;
    }

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->Heure;
    }

    public function setHeure(?\DateTimeInterface $Heure): static
    {
        $this->Heure = $Heure;

        return $this;
    }

    public function getLivreur(): ?string
    {
        return $this->Livreur;
    }

    public function setLivreur(?string $Livreur): static
    {
        $this->Livreur = $Livreur;

        return $this;
    }
}
