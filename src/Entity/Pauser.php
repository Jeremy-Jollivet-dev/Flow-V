<?php

namespace App\Entity;

use App\Repository\PauserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PauserRepository::class)]
class Pauser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?PauseReprise $pauseReprise = null;

    #[ORM\ManyToOne]
    private ?Realiser $realiser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPauseReprise(): ?PauseReprise
    {
        return $this->pauseReprise;
    }

    public function setPauseReprise(?PauseReprise $pauseReprise): static
    {
        $this->pauseReprise = $pauseReprise;

        return $this;
    }

    public function getRealiser(): ?Realiser
    {
        return $this->realiser;
    }

    public function setRealiser(?Realiser $realiser): static
    {
        $this->realiser = $realiser;

        return $this;
    }
}
