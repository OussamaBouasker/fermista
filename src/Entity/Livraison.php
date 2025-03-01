<?php

namespace App\Entity;

use App\Repository\LivraisonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;



    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Assert\NotBlank(message: "La date de livraison est obligatoire.")]
    #[Assert\GreaterThan("today", message: "La date de livraison doit être dans le futur.")]
    private ?\DateTimeInterface $Date = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\NotBlank(message: "Le lieu est obligatoire.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "Le lieu ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Regex(
        pattern: "/^[A-Z][a-zA-Z0-9\s]*$/",
        message: "Le lieu doit commencer par une lettre majuscule et ne contenir que des lettres, chiffres et espaces."
    )]
    private ?string $lieu = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: "Le nom du livreur est obligatoire.")]
    #[Assert\Length(
        min: 4,
        max: 255,
        minMessage: "Le nom doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le nom ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z\s]+$/",
        message: "Le nom du livreur doit contenir uniquement des lettres et des espaces, sans chiffres."
    )]
    private ?string $Livreur = null;

    /**
     * @var Collection<int, Commande>
     */
    #[ORM\OneToMany(targetEntity: Commande::class, mappedBy: 'livcom')]
    private Collection $livcom;

    public function __construct()
    {
        $this->livcom = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $Id): static
    {
        $this->id = $Id;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(?\DateTimeInterface $Date): static
    {
        $this->Date = $Date;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(?string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getLivreur(): ?string
    {
        return $this->Livreur;
    }

    public function setLivreur(?string $Livreur): static
    {
        $this->Livreur = $Livreur;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getLivcom(): Collection
    {
        return $this->livcom;
    }

    public function addLivcom(Commande $livcom): static
    {
        if (!$this->livcom->contains($livcom)) {
            $this->livcom->add($livcom);
            $livcom->setLivcom($this);
        }

        return $this;
    }

    public function removeLivcom(Commande $livcom): static
    {
        if ($this->livcom->removeElement($livcom)) {
            // set the owning side to null (unless already changed)
            if ($livcom->getLivcom() === $this) {
                $livcom->setLivcom(null);
            }
        }

        return $this;
    }
}
