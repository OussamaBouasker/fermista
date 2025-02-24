<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $reservation_date = null;

    #[ORM\Column(nullable: true)]
    private ?string $status = self::STATUS_PENDING;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prix = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        max: 255,
        maxMessage: "Le commentaire ne doit pas dépasser {{ limit }} caractères."
    )]
    private ?string $commentaire = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message: "Vous devez accepter le reglement des workshops")]
    private ?bool $confirmation = null;

    #[ORM\ManyToOne(inversedBy: 'reservation')]
    private ?Workshop $workshop = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: "Le email est obligatoire.")]

    #[Assert\Email(
        message: "L'adresse email '{{ value }}' n'est pas valide. Expl : utilisateur@domaine.extension"

    )]
    private ?string $email = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message: "Le numéro de télephone est obligatoire.")]
    #[Assert\Length(
        exactMessage: "Le numéro de téléphone doit comporter exactement 8 chiffres.",
        min: 8,
        max: 8
    )]
    #[Assert\Regex(
        pattern: "/^\d{8}$/",
        message: "Le numéro de téléphone doit comporter uniquement des chiffres."
    )]
    private ?int $num_tel = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: "Le numéro de carte bancaire est obligatoire.")]
    #[Assert\Length(
        min: 16,
        max: 16,
        exactMessage: "Le numéro de carte bancaire doit comporter exactement 16 chiffres."
    )]
    #[Assert\Regex(
        pattern: "/^\d{16}$/",
        message: "Le numéro de carte bancaire doit contenir uniquement des chiffres."
    )]
    private ?string $num_carte_bancaire = null;

    // Enum-like constants for status
    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_CANCELED = 'canceled';

    public static function getAvailableStatuses(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_CONFIRMED,
            self::STATUS_CANCELED,
        ];
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReservationDate(): ?\DateTimeInterface
    {
        return $this->reservation_date;
    }

    public function setReservationDate(?\DateTimeInterface $reservation_date): static
    {
        $this->reservation_date = $reservation_date;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(?string $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): static
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function isConfirmation(): ?bool
    {
        return $this->confirmation;
    }

    public function setConfirmation(?bool $confirmation): static
    {
        $this->confirmation = $confirmation;

        return $this;
    }

    public function getWorkshop(): ?Workshop
    {
        return $this->workshop;
    }

    public function setWorkshop(?Workshop $workshop): static
    {
        $this->workshop = $workshop;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getNumTel(): ?int
    {
        return $this->num_tel;
    }

    public function setNumTel(?int $num_tel): static
    {
        $this->num_tel = $num_tel;

        return $this;
    }

    public function getNumCarteBancaire(): ?string
    {
        return $this->num_carte_bancaire;
    }

    public function setNumCarteBancaire(?string $num_carte_bancaire): static
    {
        $this->num_carte_bancaire = $num_carte_bancaire;

        return $this;
    }
}
