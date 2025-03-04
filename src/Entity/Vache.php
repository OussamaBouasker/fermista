<?php

namespace App\Entity;

use App\Repository\VacheRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: VacheRepository::class)]
class Vache
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotNull(message: "Le nom de la vache est obligatoire.")]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z0-9]+$/",
        message: "Le nom de la vache doit contenir des lettres et des chiffres uniquement."
    )]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotNull(message: "L'âge est obligatoire.")]
    private ?int $age = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotNull(message: "La race est obligatoire.")]
    private ?string $race = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotNull(message: "L'état médical est obligatoire.")]
    private ?string $etatMedical = null;

    #[ORM\OneToMany(mappedBy: 'vache', targetEntity: Consultation::class)]
    private Collection $consultations;

    public function __construct()
    {
        $this->consultations = new ArrayCollection();
    }

    /**
     * @return Collection|Consultation[]
     */
    public function getConsultations(): Collection
    {
        return $this->consultations;
    }

    public function addConsultation(Consultation $consultation): self
    {
        if (!$this->consultations->contains($consultation)) {
            $this->consultations[] = $consultation;
            $consultation->setVache($this);
        }

        return $this;
    }

    public function removeConsultation(Consultation $consultation): self
    {
        if ($this->consultations->removeElement($consultation)) {
            // set the owning side to null (unless already changed)
            if ($consultation->getVache() === $this) {
                $consultation->setVache(null);
            }
        }

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
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
}