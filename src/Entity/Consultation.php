<?php

namespace App\Entity;

use App\Repository\ConsultationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: ConsultationRepository::class)]
class Consultation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotNull(message: "Le lieu ne peut pas être vide.")]
    #[Assert\Regex(
        pattern: "/^[A-Za-z0-9À-ÿ\s]+$/",
        message: "Le lieu ne doit contenir que des lettres et des chiffres."
    )]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Assert\NotNull(message: "La date ne peut pas être vide.")]
    #[Assert\GreaterThan("today", message: "La date doit être après aujourd’hui.")]
    private ?\DateTimeInterface $date = null;


    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    #[Assert\NotNull(message: "L'heure ne peut pas être vide.")]
    // #[Assert\GreaterThan("now", message: "L'heure doit être dans le futur.")]
    private ?\DateTimeInterface $heure = null;


    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotNull(message: "Le lieu ne peut pas être vide.")]
    #[Assert\Regex(
        pattern: "/^[A-Za-z0-9À-ÿ\s]+$/",
        message: "Le lieu ne doit contenir que des lettres et des chiffres."
    )]
    private ?string $lieu = null;

    #[ORM\OneToOne(targetEntity: RapportMedical::class, inversedBy: "consultation", cascade: ['persist'])]
    #[ORM\JoinColumn(name: "rapportmedical_id", referencedColumnName: "id", nullable: true)]
    private ?RapportMedical $rapportmedical = null;

    public function getRapportmedical(): ?RapportMedical
    {
        return $this->rapportmedical;
    }

    public function setRapportmedical(?RapportMedical $rapportmedical): static
    {
        $this->rapportmedical = $rapportmedical;

        // Synchronise la relation bidirectionnelle
        if ($rapportmedical !== null && $rapportmedical->getConsultation() !== $this) {
            $rapportmedical->setConsultation($this);
        }

        return $this;
    }



    #[Assert\Callback]
    public function validateDateHeure(ExecutionContextInterface $context): void
    {
        if ($this->date && $this->heure) {
            // Combine la date et l'heure pour obtenir le moment complet de la consultation
            $dateTimeConsultation = new \DateTime(
                $this->date->format('Y-m-d') . ' ' . $this->heure->format('H:i:s')
            );

            // 1. La consultation doit être au moins 1 heure dans le futur
            $dateTimeMin = new \DateTime('+1 hour');
            if ($dateTimeConsultation < $dateTimeMin) {
                $context->buildViolation('La consultation doit être prévue au moins 1 heure dans le futur.')
                    ->atPath('date')
                    ->addViolation();
            }

            // 2. La consultation ne peut pas avoir lieu le week-end (samedi ou dimanche)
            // Le format 'N' retourne 6 pour samedi et 7 pour dimanche
            if (in_array($dateTimeConsultation->format('N'), [6, 7])) {
                $context->buildViolation('La consultation ne peut pas être programmée le week-end.')
                    ->atPath('date')
                    ->addViolation();
            }

            // 3. L'heure doit être comprise entre 09:00 et 18:00 (heures de bureau)
            $heureConsultation = (int)$this->heure->format('H');
            if ($heureConsultation < 9 || $heureConsultation >= 18) {
                $context->buildViolation('L\'heure de la consultation doit être entre 09h00 et 18h00.')
                    ->atPath('heure')
                    ->addViolation();
            }
        }
    }

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

        return $this;
    }

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->heure;
    }

    public function setHeure(?\DateTimeInterface $heure): static
    {
        $this->heure = $heure;

        return $this;
    }



    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(?string $lieu): static
    {
        $this->lieu = $lieu;
        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }
}
