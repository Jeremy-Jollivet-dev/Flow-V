<?php

namespace App\Entity;

use App\Repository\PointsMAPRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PointsMAPRepository::class)]
class PointsMAP
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 9, scale: 6)]
    private ?string $lat = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 9, scale: 6)]
    private ?string $lon = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $details = null;

    #[ORM\ManyToOne]
    private ?TypeDePoints $typeDePoints = null;
    
    #[ORM\ManyToOne(inversedBy: 'pointsMAPs' )]
    private ?Parcours $parcours = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(float $lat): static
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLon(): ?string
    {
        return $this->lon;
    }

    public function setLon(float $lon): static
    {
        $this->lon = $lon;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): static
    {
        $this->details = $details;

        return $this;
    }

    public function getTypeDePoints(): ?TypeDePoints
    {
        return $this->typeDePoints;
    }

    public function setTypeDePoints(?TypeDePoints $typeDePoints): static
    {
        $this->typeDePoints = $typeDePoints;

        return $this;
    }

    public function getParcours(): ?Parcours
    {
        return $this->parcours;
    }

    public function setParcours(?Parcours $parcours): static
    {
        $this->parcours = $parcours;

        return $this;
    }
}
