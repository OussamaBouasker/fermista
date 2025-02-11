<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateCommande = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $statut = null;

    #[ORM\Column(nullable: true)]
    private ?float $montantTotal = null;

    /**
     * @var Collection<int, Produit>
     */
    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'commande')]
    private Collection $prodcommande;

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
}
