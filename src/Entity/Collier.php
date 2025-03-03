<?php

namespace App\Entity;

use App\Repository\CollierRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: CollierRepository::class)]
class Collier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: "La référence est obligatoire.")]
    #[Assert\Length(
        min: 8,
        max: 8,
        minMessage: "La référence doit comporter exactement 8 caractères.",
        maxMessage: "La référence doit comporter exactement 8 caractères."
    )]

    #[Assert\Regex(
        pattern: "/^(?=.*[a-zA-Z])(?=.*\d).+$/",
        message: "La référence doit contenir au moins une lettre et un chiffre."
    )]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z0-9]+$/",
        message: "La référence doit contenir uniquement des lettres et des chiffres."
    )]
    private ?string $reference = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: "La taille est obligatoire.")]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z0-9]+$/",
        message: "La taille peut contenir uniquement des lettres et des chiffres."
    )]
    private ?string $taille = null;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Assert\NotNull(message: "La valeur de la température est obligatoire.")]
    #[Assert\Range(
        min: 36,
        max: 40.5,
        notInRangeMessage: "La température doit être comprise entre {{ min }} et {{ max }}."
    )]
    private ?float $valeurTemperature = null;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Assert\NotNull(message: "La valeur de l'agitation est obligatoire.")]
    #[Assert\Range(
        min: 0,
        max: 10,
        notInRangeMessage: "L'agitation doit être comprise entre {{ min }} et {{ max }}."
    )]
    private ?float $valeurAgitation = null;

    #[ORM\OneToOne(targetEntity: Vache::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    #[Assert\NotNull(message: "L'identifiant de la vache est obligatoire.")]
    private ?Vache $vache = null;

    // Getters et Setters

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

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(?string $taille): self
    {
        $this->taille = $taille;
        return $this;
    }

    public function getValeurTemperature(): ?float
    {
        return $this->valeurTemperature;
    }

    public function setValeurTemperature(?float $valeurTemperature): self
    {
        $this->valeurTemperature = $valeurTemperature;
        return $this;
    }

    public function getValeurAgitation(): ?float
    {
        return $this->valeurAgitation;
    }

    public function setValeurAgitation(?float $valeurAgitation): self
    {
        $this->valeurAgitation = $valeurAgitation;
        return $this;
    }

    public function getVache(): ?Vache
    {
        return $this->vache;
    }

    public function setVache(?Vache $vache): self
    {
        $this->vache = $vache;
        return $this;
    }
}
