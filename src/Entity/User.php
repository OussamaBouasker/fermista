<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, nullable: true, unique: true)]
    #[Assert\NotBlank(message: 'L\'adresse email est obligatoire.')]
    #[Assert\Email(message: 'L\'adresse email {{ value }} n\'est pas valide.')]
    private ?string $email = null;


    #[ORM\Column(type: 'json', nullable: true)]
    private array $roles = [];


    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message: 'Le mot de passe est obligatoire.')]
    #[Assert\Length(min: 8, minMessage: 'Le mot de passe doit contenir au moins 8 caractères.')]
    #[Assert\Regex(
        pattern: '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
        message: 'Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial.',
        groups: ['registration']
    )]
    
    private ?string $password = null;

    #[ORM\Column(length: 10, nullable: true)]
    #[Assert\NotBlank(message: 'Le prénom est obligatoire.')]
    #[Assert\Length(min: 2, max: 10, minMessage: 'Le prénom doit contenir au moins 2 caractères.')]
    #[Assert\Regex(pattern: '/^[a-zA-ZÀ-ÿ\s-]+$/', message: 'Le prénom ne doit contenir que des lettres et des espaces.')]
    private ?string $firstName = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\NotBlank(message: 'Le nom est obligatoire.')]
    #[Assert\Length(min: 2, max: 50, minMessage: 'Le nom doit contenir au moins 2 caractères.')]
    #[Assert\Regex(pattern: '/^[a-zA-ZÀ-ÿ\s-]+$/', message: 'Le nom ne doit contenir que des lettres et des espaces.')]
    private ?string $lastName = null;

    #[ORM\Column(length: 15, nullable: true)]
    #[Assert\NotBlank(message: 'Le numéro de téléphone est obligatoire.')]
    #[Assert\Regex(
        pattern: '/^\+?[0-9]{8,15}$/',
        message: 'Le numéro de téléphone doit contenir entre 8 et 15 chiffres et peut commencer par un "+".'
    )]
    private ?string $number = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $state = null;

    #[ORM\OneToMany(targetEntity: Reclamation::class, mappedBy: 'user', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $reclamations;

    #[ORM\Column]
    private bool $isVerified = false;

    public function __construct()
    {
        $this->reclamations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    // Dans l'entité User

// Dans ton entité User
public function getRoles(): array
{
    // Récupérer les rôles depuis la propriété $roles de ton entité
    $roles = $this->roles;

    // Dictionnaire des rôles lisibles
    $roleNames = [
        'ROLE_ADMIN' => 'Administrateur',
        'ROLE_FORMATEUR' => 'Formateur',
        'ROLE_AGRICULTOR' => 'Agriculteur',
        'ROLE_VETERINAIR' => 'Vétérinaire',
        'ROLE_CLIENT' => 'Client',
        
        // Ajoute d'autres rôles ici
    ];

    // Transformer les rôles en noms lisibles
    return array_map(function($role) use ($roleNames) {
        return $roleNames[$role] ?? $role; // Si le rôle n'existe pas dans le tableau, laisse-le tel quel
    }, $roles);
    return $this->roles ?: ['ROLE_USER'];
}



    public function setRoles(?array $roles): static
    {
        $this->roles = $roles ?? [];
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): static
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): static
    {
        $this->number = $number;
        return $this;
    }

    public function getState(): ?bool
    {
        return $this->state;
    }

    public function setState(?bool $state): static
    {
        $this->state = $state;
        return $this;
    }

    public function eraseCredentials(): void
    {
        // Effacer les données sensibles temporaires ici si nécessaire
    }

    public function getReclamations(): Collection
    {
        return $this->reclamations;
    }

    public function addReclamation(Reclamation $reclamation): static
    {
        if (!$this->reclamations->contains($reclamation)) {
            $this->reclamations->add($reclamation);
            $reclamation->setUser($this);
        }

        return $this;
    }

    public function removeReclamation(Reclamation $reclamation): static
    {
        if ($this->reclamations->removeElement($reclamation)) {
            if ($reclamation->getUser() === $this) {
                $reclamation->setUser(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }
    
}
