<?php

namespace App\Entity;

use App\Repository\DifficulteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DifficulteRepository::class)]
class Difficulte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $libelleDifficulte = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleDifficulte(): ?string
    {
        return $this->libelleDifficulte;
    }

    public function setLibelleDifficulte(string $libelleDifficulte): static
    {
        $this->libelleDifficulte = $libelleDifficulte;

        return $this;
    }
}
