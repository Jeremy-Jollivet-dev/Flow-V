<?php

namespace App\Entity;

use App\Repository\TypeDeParcoursRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeDeParcoursRepository::class)]
class TypeDeParcours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $libelleParcours = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleParcours(): ?string
    {
        return $this->libelleParcours;
    }

    public function setLibelleParcours(string $libelleParcours): static
    {
        $this->libelleParcours = $libelleParcours;

        return $this;
    }
}
