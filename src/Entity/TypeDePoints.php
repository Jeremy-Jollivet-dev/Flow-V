<?php

namespace App\Entity;

use App\Repository\TypeDePointsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeDePointsRepository::class)]
class TypeDePoints
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $libelleTypePoint = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleTypePoint(): ?string
    {
        return $this->libelleTypePoint;
    }

    public function setLibelleTypePoint(string $libelleTypePoint): static
    {
        $this->libelleTypePoint = $libelleTypePoint;

        return $this;
    }
}
