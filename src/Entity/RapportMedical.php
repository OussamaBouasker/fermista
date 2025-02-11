<?php

namespace App\Entity;

use App\Repository\RapportMedicalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RapportMedicalRepository::class)]
class RapportMedical
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $num = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $race = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $historique_de_maladie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cas_medical = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $solution = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNum(): ?int
    {
        return $this->num;
    }

    public function setNum(?int $num): static
    {
        $this->num = $num;

        return $this;
    }

    public function getRace(): ?string
    {
        return $this->race;
    }

    public function setRace(?string $race): static
    {
        $this->race = $race;

        return $this;
    }

    public function getHistoriqueDeMaladie(): ?string
    {
        return $this->historique_de_maladie;
    }

    public function setHistoriqueDeMaladie(?string $historique_de_maladie): static
    {
        $this->historique_de_maladie = $historique_de_maladie;

        return $this;
    }

    public function getCasMedical(): ?string
    {
        return $this->cas_medical;
    }

    public function setCasMedical(?string $cas_medical): static
    {
        $this->cas_medical = $cas_medical;

        return $this;
    }

    public function getSolution(): ?string
    {
        return $this->solution;
    }

    public function setSolution(?string $solution): static
    {
        $this->solution = $solution;

        return $this;
    }
}
