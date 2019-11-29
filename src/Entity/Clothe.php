<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClotheRepository")
 */
class Clothe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $clothe_type;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $clothe_brand;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $clothe_color;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $clothe_state;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $clothe_universe;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Advert", inversedBy="clothe", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $clothe_advert;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClotheType(): ?string
    {
        return $this->clothe_type;
    }

    public function setClotheType(string $clothe_type): self
    {
        $this->clothe_type = $clothe_type;

        return $this;
    }

    public function getClotheBrand(): ?string
    {
        return $this->clothe_brand;
    }

    public function setClotheBrand(string $clothe_brand): self
    {
        $this->clothe_brand = $clothe_brand;

        return $this;
    }

    public function getClotheColor(): ?string
    {
        return $this->clothe_color;
    }

    public function setClotheColor(?string $clothe_color): self
    {
        $this->clothe_color = $clothe_color;

        return $this;
    }

    public function getClotheState(): ?string
    {
        return $this->clothe_state;
    }

    public function setClotheState(string $clothe_state): self
    {
        $this->clothe_state = $clothe_state;

        return $this;
    }

    public function getClotheUniverse(): ?string
    {
        return $this->clothe_universe;
    }

    public function setClotheUniverse(string $clothe_universe): self
    {
        $this->clothe_universe = $clothe_universe;

        return $this;
    }

    public function getClotheAdvert(): ?Advert
    {
        return $this->clothe_advert;
    }

    public function setClotheAdvert(Advert $clothe_advert): self
    {
        $this->clothe_advert = $clothe_advert;

        return $this;
    }
}
