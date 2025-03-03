<?php

namespace App\Entity;

use App\Repository\ArgTempRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArgTempRepository::class)]
class ArgTemp
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $temperature = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $time_receive = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTemperature(): ?string
    {
        return $this->temperature;
    }

    public function setTemperature(?string $temperature): static
    {
        $this->temperature = $temperature;

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
