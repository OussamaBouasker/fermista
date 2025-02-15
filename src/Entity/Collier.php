<?php

namespace App\Entity;

use App\Repository\CollierRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: CollierRepository::class)]
class Collier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: false)]
    #[Assert\NotBlank(message: "La référence est obligatoire.")]
    #[Assert\Length(min: 8, max: 255, minMessage: "La référence doit comporter au moins 8 caractères.")]
    #[Assert\Regex(pattern: "/^[a-zA-Z0-9]+$/", message: "La référence doit contenir uniquement des lettres et des chiffres.")]
    private ?string $reference = null;

    #[ORM\Column(length: 255, nullable: false)]
    #[Assert\NotBlank(message: "La taille est obligatoire.")]
    #[Assert\Regex(pattern: "/^[a-zA-Z0-9]+$/", message: "La taille peut contenir des lettres et des chiffres.")]
    private ?string $taille = null;

    #[ORM\Column(type: 'float', nullable: false)]
    #[Assert\NotBlank(message: "La valeur de la température est obligatoire.")]
    #[Assert\Range(min: 37, max: 40.5, notInRangeMessage: "La température doit être comprise entre {{ min }} et {{ max }}.")]
    private ?float $valeurTemperature = null;

    #[ORM\Column(type: 'float', nullable: false)]
    #[Assert\NotBlank(message: "La valeur de l'agitation est obligatoire.")]
    #[Assert\Range(min: 0, max: 20, notInRangeMessage: "L'agitation doit être comprise entre {{ min }} et {{ max }}.")]
    private ?float $valeurAgitation = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'], orphanRemoval: false)]
    #[Assert\NotNull(message: "L'id de vache est obligatoire.")]
    private ?Vache $vache = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): static
    {
        $this->reference = $reference;
        return $this;
    }

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(?string $taille): static
    {
        $this->taille = $taille;
        return $this;
    }

    public function getValeurTemperature(): ?float
    {
        return $this->valeurTemperature;
    }

    public function setValeurTemperature(?float $valeurTemperature): static
    {
        $this->valeurTemperature = $valeurTemperature;
        return $this;
    }

    public function getValeurAgitation(): ?float
    {
        return $this->valeurAgitation;
    }

    public function setValeurAgitation(?float $valeurAgitation): static
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
