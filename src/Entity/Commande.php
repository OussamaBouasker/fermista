<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
<<<<<<< HEAD
use Symfony\Component\Validator\Constraints as Assert;


=======
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
<<<<<<< HEAD
    #[Assert\NotBlank(message: "La date de la commande est requise.")]
    #[Assert\Type(type: "\DateTimeInterface", message: "La date doit être valide.")]
    #[Assert\GreaterThan("today", message: "Il faut une date supérieure à aujourd'hui.")]
    private ?\DateTimeInterface $dateCommande = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: "Le statut de la commande est requis.")]
    #[Assert\Length(min: 3, max: 50, minMessage: "Le statut doit contenir au moins {{ limit }} caractères.", maxMessage: "Le statut ne peut pas contenir plus de {{ limit }} caractères.")]
    private ?string $statut = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message: "Le montant total est requis.")]
    #[Assert\PositiveOrZero(message: "Le montant doit être un nombre positif ou égal à zéro.")]
    #[Assert\Type(type: 'numeric', message: "Le montant doit être un nombre.")]
=======
    private ?\DateTimeInterface $dateCommande = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $statut = null;

    #[ORM\Column(nullable: true)]
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
    private ?float $montantTotal = null;

    /**
     * @var Collection<int, Produit>
     */
    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'commande')]
    private Collection $prodcommande;

    #[ORM\ManyToOne(inversedBy: 'livcom')]
<<<<<<< HEAD
    #[Assert\NotNull(message: "Veuillez sélectionner une livraison associée.")]
=======
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
    private ?Livraison $livcom = null;

    public function __construct()
    {
        $this->prodcommande = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?string $Id): static
    {
        $this->Id = $Id;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(?\DateTimeInterface $dateCommande): static
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getMontantTotal(): ?float
    {
        return $this->montantTotal;
    }

    public function setMontantTotal(?float $montantTotal): static
    {
        $this->montantTotal = $montantTotal;

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProdcommande(): Collection
    {
        return $this->prodcommande;
    }

    public function addProdcommande(Produit $prodcommande): static
    {
        if (!$this->prodcommande->contains($prodcommande)) {
            $this->prodcommande->add($prodcommande);
            $prodcommande->setCommande($this);
        }

        return $this;
    }

    public function removeProdcommande(Produit $prodcommande): static
    {
        if ($this->prodcommande->removeElement($prodcommande)) {
            // set the owning side to null (unless already changed)
            if ($prodcommande->getCommande() === $this) {
                $prodcommande->setCommande(null);
            }
        }

        return $this;
    }

    public function getLivcom(): ?Livraison
    {
        return $this->livcom;
    }

    public function setLivcom(?Livraison $livcom): static
    {
        $this->livcom = $livcom;

        return $this;
    }
}
