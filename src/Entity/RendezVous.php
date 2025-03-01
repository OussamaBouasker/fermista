<?php

namespace App\Entity;

use App\Repository\RendezVousRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: RendezVousRepository::class)]
class RendezVous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

<<<<<<< HEAD
    // Date du rendez-vous
=======
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: false)]
    #[Assert\NotBlank(message: "La date du rendez-vous ne peut pas être vide.")]
    private ?\DateTimeInterface $date = null;

<<<<<<< HEAD
    // Heure du rendez-vous
=======
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: false)]
    #[Assert\NotBlank(message: "L'heure du rendez-vous est requise.")]
    private ?\DateTimeInterface $heure = null;

<<<<<<< HEAD
    // Sexe (pour information ou contexte, par exemple pour la personne concernée)
=======
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
    #[ORM\Column(length: 50, nullable: false)]
    #[Assert\NotBlank(message: "Le sexe ne peut pas être vide.")]
    private ?string $sex = null;

<<<<<<< HEAD
    // Cause du rendez-vous
=======
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
    #[ORM\Column(length: 255, nullable: false)]
    #[Assert\NotBlank(message: "Veuillez préciser la cause du rendez-vous.")]
    #[Assert\Length(
        min: 10,
        minMessage: "La cause doit contenir au moins {{ limit }} caractères.",
        max: 255,
        maxMessage: "La cause ne doit pas dépasser {{ limit }} caractères."
    )]
    private ?string $cause = null;

<<<<<<< HEAD
    // Le vétérinaire concerné (relation ManyToOne)
    #[ORM\ManyToOne(targetEntity: \App\Entity\User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?\App\Entity\User $veterinaire = null;

    public function getVeterinaire(): ?\App\Entity\User
    {
        return $this->veterinaire;
    }

    public function setVeterinaire(?\App\Entity\User $veterinaire): self
    {
        $this->veterinaire = $veterinaire;
        return $this;
    }

    #[ORM\ManyToOne(targetEntity: \App\Entity\User::class)]
    #[ORM\JoinColumn(nullable: false)] // Cette ligne signifie que agriculteur_id ne peut pas être NULL
    private ?User $agriculteur = null;

    // Getter et Setter
    public function getAgriculteur(): ?\App\Entity\User
    {
        return $this->agriculteur;
    }

    public function setAgriculteur(?\App\Entity\User $agriculteur): self
    {
        $this->agriculteur = $agriculteur;
        return $this;
    }
    // Statut du rendez-vous (par défaut "en attente")
    #[ORM\Column(length: 20)]
    private ?string $status = 'en attente';

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    // Getters et setters pour l'ID, la date, l'heure, le sexe et la cause

=======
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): static
    {
        $this->date = $date;
<<<<<<< HEAD
=======

>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
        return $this;
    }

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->heure;
    }

    public function setHeure(?\DateTimeInterface $heure): static
    {
        $this->heure = $heure;
<<<<<<< HEAD
=======

>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(?string $sex): static
    {
        $this->sex = $sex;
<<<<<<< HEAD
=======

>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
        return $this;
    }

    public function getCause(): ?string
    {
        return $this->cause;
    }

    public function setCause(?string $cause): static
    {
        $this->cause = $cause;
<<<<<<< HEAD
        return $this;
    }

    // Validation personnalisée : la date ne peut pas être dans le passé ni tomber un week-end
=======

        return $this;
    }


>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
    #[Assert\Callback]
    public function validateFields(ExecutionContextInterface $context): void
    {
        if ($this->date) {
            if ($this->date < new \DateTime('today')) {
                $context->buildViolation("La date du rendez-vous ne peut pas être dans le passé.")
                    ->atPath('date')
                    ->addViolation();
            }
<<<<<<< HEAD
=======

>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
            // Vérifier si la date correspond à un week-end
            $dayOfWeek = (int) $this->date->format('N'); // 6 = samedi, 7 = dimanche
            if ($dayOfWeek >= 6) {
                $context->buildViolation("Les rendez-vous ne peuvent pas être pris le week-end (samedi ou dimanche).")
                    ->atPath('date')
                    ->addViolation();
            }
        }
    }
}
