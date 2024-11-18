<?php

namespace App\Entity;

use App\Repository\ParcoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\PointsMAP;

#[ORM\Entity(repositoryClass: ParcoursRepository::class)]
class Parcours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $nomParcours;

    #[ORM\Column(type: 'boolean')]
    private $prive;

    #[ORM\Column(type: 'boolean')]
    private $exclusif;

    #[ORM\Column(type: 'boolean')]
    private $status;

    #[ORM\Column(type: 'datetime')]
    private $dateCreation;

    #[ORM\Column(type: 'datetime')]
    private $dateModification;

    #[ORM\ManyToOne(targetEntity: Users::class)]
    private $users;

    #[ORM\ManyToOne(targetEntity: TypeDeParcours::class)]
    private $typeDeParcours;

    #[ORM\ManyToOne(targetEntity: Difficulte::class)]
    private $difficulte;

    #[ORM\OneToMany(mappedBy: 'parcours', targetEntity: PointsMAP::class, cascade: ['persist', 'remove'])]
    private $pointsMAPs;

    public function __construct()
    {
        $this->pointsMAPs = new ArrayCollection();
        $this->status = true;  
        $this->dateCreation = new \DateTime(); // Date actuelle
        $this->dateModification = new \DateTime(); ;
    }

    public function getid(): ?int
    {
        return $this->id;
    }

    public function getNomParcours(): ?string
    {
        return $this->nomParcours;
    }

    public function setNomParcours(string $nomParcours): static
    {
        $this->nomParcours = $nomParcours;
        return $this;
    }

    public function isPrive(): ?bool
    {
        return $this->prive;
    }

    public function setPrive(bool $prive): static
    {
        $this->prive = $prive;
        return $this;
    }

    public function getExclusif(): ?bool
    {
        return $this->exclusif;
    }

    public function setExclusif(bool $exclusif): static
    {
        $this->exclusif = $exclusif;
        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): static
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    public function getDateModification(): ?\DateTimeInterface
    {
        return $this->dateModification;
    }

    public function setDateModification(\DateTimeInterface $dateModification): static
    {
        $this->dateModification = $dateModification;
        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): static
    {
        $this->users = $users;
        return $this;
    }

    public function getTypeDeParcours(): ?TypeDeParcours
    {
        return $this->typeDeParcours;
    }

    public function setTypeDeParcours(?TypeDeParcours $typeDeParcours): static
    {
        $this->typeDeParcours = $typeDeParcours;
        return $this;
    }

    public function getDifficulte(): ?Difficulte
    {
        return $this->difficulte;
    }

    public function setDifficulte(?Difficulte $difficulte): static
    {
        $this->difficulte = $difficulte;
        return $this;
    }

    /**
     * @return Collection<int, PointsMAP>
     */
    public function getPointsMAPs(): Collection
    {
        return $this->pointsMAPs;
    }

    public function addPointsMAP(PointsMAP $pointsMAP): static
    {
        if (!$this->pointsMAPs->contains($pointsMAP)) {
            $this->pointsMAPs->add($pointsMAP);
            $pointsMAP->setParcours($this);
        }
        return $this;
    }
    

    public function setPointsMAPs(array $points): self
    {
        // Vider la collection existante de points
        $this->pointsMAPs->clear();

        // Ajouter chaque point du tableau
        foreach ($points as $point) {
            $this->addPointsMAP($point); // Assurez-vous que la méthode `addPointsMAP` est définie
        }

        return $this;
    }
    public function removePointsMAP(PointsMAP $point): self
    {
        if ($this->pointsMAPs->contains($point)) {
            $this->pointsMAPs->removeElement($point);
            if ($point->getParcours() === $this) {
                $point->setParcours(null); // Dissocie le point du parcours, si nécessaire
            }
        }
        return $this;
    }
    public function removePointsMAP2():self
    {
        $this->pointsMAPs->clear();
    }
}
