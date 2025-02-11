<?php

namespace App\Entity;

use App\Repository\CollierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CollierRepository::class)]
class Collier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column(length: 255)]
    private ?string $taille = null;

    #[ORM\Column(length: 255)]
    private ?string $valeurTemperature = null;

    #[ORM\Column(length: 255)]
    private ?string $valeurAgitation = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'] , orphanRemoval:false)]
    private ?Vache $vache = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(string $taille): static
    {
        $this->taille = $taille;

        return $this;
    }

    public function getValeurTemperature(): ?string
    {
        return $this->valeurTemperature;
    }

    public function setValeurTemperature(string $valeurTemperature): static
    {
        $this->valeurTemperature = $valeurTemperature;

        return $this;
    }

    public function getValeurAgitation(): ?string
    {
        return $this->valeurAgitation;
    }

    public function setValeurAgitation(string $valeurAgitation): static
    {
        $this->valeurAgitation = $valeurAgitation;

        return $this;
    }

    public function getVache(): ?Vache
    {
        return $this->vache;
    }

    public function setVache(?Vache $vache): static
    {
        $this->vache = $vache;

        return $this;
    }
}
