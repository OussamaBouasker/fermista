<?php

namespace App\Entity;

use App\Repository\WorkshopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
<<<<<<< HEAD
use Symfony\Component\HttpFoundation\File\UploadedFile;
=======
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkshopRepository::class)]
class Workshop
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: "Le titre est obligatoire.")]
    #[Assert\Length(
<<<<<<< HEAD
        min: 3,
        minMessage: "Le titre doit comporter au moins 3 caractères."
    )]
    private ?string $titre = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: "La Description est obligatoire.")]
=======
        min: 6,
        minMessage: "Le titre doit comporter au moins 6 caractères."
    )]
    private ?string $titre = null;
    
    #[ORM\Column(length: 255, nullable: true)]
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
    #[Assert\Length(
        min: 10,
        minMessage: "La description doit comporter au moins 10 caractères."
    )]
    private ?string $description = null;
<<<<<<< HEAD

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Assert\NotBlank(message: "La date est obligatoire.")]
    #[Assert\GreaterThan("now", message: "L'heure doit être supérieure à l'heure actuelle.")]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: "Le prix est obligatoire.")]
    #[Assert\Regex(
        pattern: "/^\d+$/",
        message: "Le prix doit être composé de chiffres uniquement."
    )]
    private ?string $prix = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: "Le thème est obligatoire.")]
=======
    
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Assert\NotBlank(message: "time .")]
    #[Assert\GreaterThan("now", message: "L'heure doit être supérieure à l'heure actuelle.")]
    private ?\DateTimeInterface $date = null;    

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prix = null;
    
    #[ORM\Column(length: 255, nullable: true)]
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
    #[Assert\Length(
        max: 10,
        maxMessage: "Le thème ne doit pas dépasser 10 caractères."
    )]
    private ?string $theme = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
<<<<<<< HEAD
    #[Assert\NotBlank(message: "L'heure ne peut pas être vide.")]

=======
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
    private ?\DateTimeInterface $duration = null;

    /**
     * @var Collection<int, Reservation>
     */
<<<<<<< HEAD
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'workshop', orphanRemoval: true)]
    private Collection $reservation;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message: "Le nombre maximum de places est requis.")]
    #[Assert\GreaterThan(value: 10, message: "Le nombre maximum de places doit être supérieur à 10.")]
    private ?int $nbrPlacesMax = null;
=======
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'workshop',orphanRemoval:true)]
    private Collection $reservation;

    #[ORM\Column(nullable: true)]
    private ?int $nbr_places_max_ = null;
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f

    #[ORM\Column(nullable: true)]
    private ?int $nbr_places_restantes = null;

    #[ORM\Column(length: 255, nullable: true)]
<<<<<<< HEAD
    #[Assert\NotBlank(message: "Vous devez sélectionner un type.")]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    // #[Assert\NotBlank(message: "L'ajout d'une image est obligatoire.")]

    private ?string $image = null;

    #[ORM\Column(length: 255,nullable: true)]
    private ?string $meetlink = null;


    public const TYPE_LIVE_WORKSHOP = 'Atelier Live';
    public const TYPE_SELF_PACED_WORKSHOP = 'Formation Autonome';

=======
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    public const TYPE_LIVE_WORKSHOP = 'Atelier Live';
    public const TYPE_SELF_PACED_WORKSHOP = 'Formation Autonome';
    
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
    public static function getAvailableWorkshopTypes(): array
    {
        return [
            self::TYPE_LIVE_WORKSHOP,
            self::TYPE_SELF_PACED_WORKSHOP,
        ];
    }

    public function __construct()
    {
        $this->reservation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
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

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(?string $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(?string $theme): static
    {
        $this->theme = $theme;

        return $this;
    }

    public function getDuration(): ?\DateTimeInterface
    {
        return $this->duration;
    }

    public function setDuration(?\DateTimeInterface $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservation(): Collection
    {
        return $this->reservation;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservation->contains($reservation)) {
            $this->reservation->add($reservation);
            $reservation->setWorkshop($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservation->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getWorkshop() === $this) {
                $reservation->setWorkshop(null);
            }
        }

        return $this;
    }

<<<<<<< HEAD

    public function getNbrPlacesMax(): ?int
    {
        return $this->nbrPlacesMax;
=======
    public function getNbrPlacesMax(): ?int
    {
        return $this->nbr_places_max_;
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
    }

    public function setNbrPlacesMax(?int $nbr_places_max_): static
    {
<<<<<<< HEAD
        $this->nbrPlacesMax = $nbr_places_max_;
=======
        $this->nbr_places_max_ = $nbr_places_max_;
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f

        return $this;
    }

    public function getNbrPlacesRestantes(): ?int
    {
        return $this->nbr_places_restantes;
    }

    public function setNbrPlacesRestantes(?int $nbr_places_restantes): static
    {
        $this->nbr_places_restantes = $nbr_places_restantes;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }
<<<<<<< HEAD

    public function getMeetlink(): ?string
    {
        return $this->meetlink;
    }

    public function setMeetlink(string $meetlink): static
    {
        $this->meetlink = $meetlink;

        return $this;
    }
=======
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
}
