<?php

namespace App\Entity;

use App\Repository\VacheRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;

#[ORM\Entity(repositoryClass: VacheRepository::class)]
class Vache
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Length(
        min: 1,
        max: 2,
        minMessage: "L'âge doit comporter exactement 1 caractère.",
        maxMessage: "L'âge doit comporter exactement 2 caractères."
    )]
    #[Assert\NotNull(message: "L'âge est obligatoire.")]
    private ?int $age = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotNull(message: "La race est obligatoire.")]
    #[Assert\Regex(
        pattern: "/^(?=.*[a-zA-Z]).+$/",
        message: "La race doit contenir uniquement des lettres."
    )]
    private ?string $race = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotNull(message: "L'état médical est obligatoire.")]
    #[Assert\Regex(
        pattern: "/^(?=.*[a-zA-Z]).+$/",
        message: "L'état médical doit contenir uniquement des lettres."
    )]
    private ?string $etatMedical = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotNull(message: "Le nom de la vache est obligatoire.")]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z0-9]+$/",
        message: "Le nom de la vache doit contenir des lettres et des chiffres uniquement."
    )]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): static
    {
        $this->age = $age;

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

    public function getEtatMedical(): ?string
    {
        return $this->etatMedical;
    }

    public function setEtatMedical(?string $etatMedical): static
    {
        $this->etatMedical = $etatMedical;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
