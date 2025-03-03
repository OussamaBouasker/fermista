<?php

namespace App\Entity;

use App\Repository\ArgAgitRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArgAgitRepository::class)]
class ArgAgit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $accel_x = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $accel_y = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $accel_z = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $time_receive = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccelX(): ?string
    {
        return $this->accel_x;
    }

    public function setAccelX(?string $accel_x): static
    {
        $this->accel_x = $accel_x;

        return $this;
    }

    public function getAccelY(): ?string
    {
        return $this->accel_y;
    }

    public function setAccelY(?string $accel_y): static
    {
        $this->accel_y = $accel_y;

        return $this;
    }

    public function getAccelZ(): ?string
    {
        return $this->accel_z;
    }

    public function setAccelZ(?string $accel_z): static
    {
        $this->accel_z = $accel_z;

        return $this;
    }

    public function getTimeReceive(): ?\DateTimeInterface
    {
        return $this->time_receive;
    }

    public function setTimeReceive(?\DateTimeInterface $time_receive): static
    {
        $this->time_receive = $time_receive;

        return $this;
    }
}
