<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImmovableRepository")
 */
class Immovable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $immovable_type;

    /**
     * @ORM\Column(type="float")
     */
    private $immovable_surface;

    /**
     * @ORM\Column(type="integer")
     */
    private $immovable_room;

    /**
     * @ORM\Column(type="string", length=1, nullable=true)
     */
    private $immovable_energy;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Advert", inversedBy="immovable", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $immovable_advert;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImmovableType(): ?string
    {
        return $this->immovable_type;
    }

    public function setImmovableType(string $immovable_type): self
    {
        $this->immovable_type = $immovable_type;

        return $this;
    }

    public function getImmovableSurface(): ?float
    {
        return $this->immovable_surface;
    }

    public function setImmovableSurface(float $immovable_surface): self
    {
        $this->immovable_surface = $immovable_surface;

        return $this;
    }

    public function getImmovableRoom(): ?int
    {
        return $this->immovable_room;
    }

    public function setImmovableRoom(int $immovable_room): self
    {
        $this->immovable_room = $immovable_room;

        return $this;
    }

    public function getImmovableEnergy(): ?string
    {
        return $this->immovable_energy;
    }

    public function setImmovableEnergy(?string $immovable_energy): self
    {
        $this->immovable_energy = $immovable_energy;

        return $this;
    }

    public function getImmovableAdvert(): ?Advert
    {
        return $this->immovable_advert;
    }

    public function setImmovableAdvert(Advert $immovable_advert): self
    {
        $this->immovable_advert = $immovable_advert;

        return $this;
    }
}
