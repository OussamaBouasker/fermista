<?php

namespace App\Entity;

use App\Repository\RapportMedicalRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RapportMedicalRepository::class)]
class RapportMedical
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Doit être un entier positif et non nul.
    #[ORM\Column(nullable: true)]
    #[Assert\NotNull(message: "Le numéro est requis.")]
    #[Assert\Positive(message: "Le numéro doit être un entier positif.")]
    private ?int $num = null;

    // Chaque mot doit débuter par une majuscule suivie de lettres minuscules.
    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\NotNull(message: "La race ne peut pas être vide.")]
    #[Assert\Regex(
        pattern: "/^(?:(?:[A-Z][a-z]+)(?:\s|$))+$/",
        message: "La race doit être composée de mots commençant par une majuscule suivis de lettres minuscules."
    )]
    private ?string $race = null;

    // Doit contenir au moins 10 caractères et ne pas inclure le mot "inconnu".
    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotNull(message: "L'historique de maladie est requis.")]
    #[Assert\Length(
        min: 10,
        minMessage: "L'historique de maladie doit contenir au moins {{ limit }} caractères."
    )]
    #[Assert\Regex(
        pattern: "/^(?!.*\binconnu\b).+$/i",
        message: "L'historique de maladie ne doit pas contenir le mot 'inconnu'."
    )]
    private ?string $historique_de_maladie = null;

    // Doit contenir au moins 10 caractères et ne doit contenir que des lettres, espaces et ponctuation limitée.
    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotNull(message: "Le cas médical est requis.")]
    #[Assert\Length(
        min: 10,
        minMessage: "Le cas médical doit contenir au moins {{ limit }} caractères."
    )]
    #[Assert\Regex(
        pattern: "/^[A-Za-zÀ-ÿ\s,.-]+$/",
        message: "Le cas médical ne doit contenir que des lettres, espaces et ponctuation (virgule, point, tiret)."
    )]
    private ?string $cas_medical = null;

    // Doit contenir au moins 10 caractères et ne doit pas être une réponse évasive.
    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotNull(message: "La solution est requise.")]
    #[Assert\Length(
        min: 10,
        minMessage: "La solution doit contenir au moins {{ limit }} caractères."
    )]
    #[Assert\Regex(
        pattern: "/^(?!.*\b(aucune solution|inconnue)\b).+$/i",
        message: "La solution doit être précise et ne doit pas être 'aucune solution' ou 'inconnue'."
    )]
    private ?string $solution = null;



    #[ORM\OneToOne(inversedBy: "rapportmedical", cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true, onDelete: "CASCADE")]
    private ?Consultation $consultation = null;

    public function getConsultation(): ?Consultation
    {
        return $this->consultation;
    }

    public function setConsultation(?Consultation $consultation): static
    {
        $this->consultation = $consultation;

        // Synchronise la relation bidirectionnelle
        if ($consultation !== null && $consultation->getRapportmedical() !== $this) {
            $consultation->setRapportmedical($this);
        }

        return $this;
    }
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
