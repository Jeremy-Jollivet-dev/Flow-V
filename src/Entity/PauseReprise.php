<?php

namespace App\Entity;

use App\Repository\PauseRepriseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PauseRepriseRepository::class)]
class PauseReprise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateDebutPause = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateFinPause = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 9, scale: 6, nullable: true)]
    private ?string $lat = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 9, scale: 6, nullable: true)]
    private ?string $lon = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebutPause(): ?\DateTimeInterface
    {
        return $this->dateDebutPause;
    }

    public function setDateDebutPause(?\DateTimeInterface $dateDebutPause): static
    {
        $this->dateDebutPause = $dateDebutPause;

        return $this;
    }

    public function getDateFinPause(): ?\DateTimeInterface
    {
        return $this->dateFinPause;
    }

    public function setDateFinPause(?\DateTimeInterface $dateFinPause): static
    {
        $this->dateFinPause = $dateFinPause;

        return $this;
    }

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(?string $lat): static
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLon(): ?string
    {
        return $this->lon;
    }

    public function setLon(?string $lon): static
    {
        $this->lon = $lon;

        return $this;
    }
}
