<?php

namespace App\Entity;
<<<<<<< HEAD

use App\Repository\ReclamationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
=======
use App\Enum\StatutReclamation;
use App\Repository\ReclamationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

<<<<<<< HEAD
    #[ORM\Column(length: 30, nullable: true)]
    #[Assert\NotBlank(message: "Le titre ne peut pas être vide.")]
    #[Assert\Length(
        min: 8,
        minMessage: "Le titre doit contenir au moins 8 caractères.",
        max: 30,
        maxMessage: "Le titre ne doit pas dépasser 30 caractères."
    )]
    #[Assert\Regex(pattern: '/^[a-zA-ZÀ-ÿ\s-]+$/', message: 'Le titre ne doit contenir que des lettres et des espaces.')]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank(message: "La description ne peut pas être vide.")]
    #[Assert\Length(
        min: 8,
        minMessage: "La description doit contenir au moins 8 caractères.",
        max: 50,
        maxMessage: "La description ne doit pas dépasser 50 caractères."
    )]
    #[Assert\Regex(pattern: '/^[a-zA-ZÀ-ÿ\s-]+$/', message: 'La déscription ne doit contenir que des lettres et des espaces.')]

    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    
    private ?string $status = self::STATUS_PENDING;


    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
   
    private ?\DateTimeInterface $dateSoumission = null;


    #[ORM\ManyToOne(inversedBy: 'reclamations')]
    #[ORM\JoinColumn(nullable: true, onDelete: "CASCADE")]
=======
    #[ORM\Column(length: 30)]
    private ?string $titre = null;

    #[ORM\Column(type: "text")]
    private string $description;

    #[ORM\Column(nullable: true)]
    private ?string $status = self::STATUS_PENDING;
   
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateSoumission = null;

    #[ORM\ManyToOne(inversedBy: 'reclamations')]
    #[ORM\JoinColumn(nullable: false ,onDelete: "CASCADE")]
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

<<<<<<< HEAD
    public function setTitre(?string $titre): static
    {
        $this->titre = $titre;
=======
    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

<<<<<<< HEAD
    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

=======
    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

   

>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
    public function getDateSoumission(): ?\DateTimeInterface
    {
        return $this->dateSoumission;
    }

<<<<<<< HEAD
    public function setDateSoumission(?\DateTimeInterface $dateSoumission): static
    {
        $this->dateSoumission = $dateSoumission;
=======
    public function setDateSoumission(\DateTimeInterface $dateSoumission): static
    {
        $this->dateSoumission = $dateSoumission;

>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
<<<<<<< HEAD
=======

>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
        return $this;
    }

    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_CANCELED = 'canceled';

<<<<<<< HEAD
    public const AVAILABLE_STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_CONFIRMED,
        self::STATUS_CANCELED,
    ];

    public static function getAvailableStatuses(): array
    {
        return self::AVAILABLE_STATUSES;
    }

=======
    public static function getAvailableStatuses(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_CONFIRMED,
            self::STATUS_CANCELED,
        ];
    }
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;
<<<<<<< HEAD
=======

>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
        return $this;
    }
}
