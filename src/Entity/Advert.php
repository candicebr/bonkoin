<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdvertRepository")
 */
class Advert
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
    private $advert_title;

    /**
     * @ORM\Column(type="float")
     */
    private $advert_price;

    /**
     * @ORM\Column(type="text")
     */
    private $advert_description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $advert_photo;

    /**
     * @ORM\Column(type="datetime")
     */
    private $advert_date;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $advert_localisation;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $advert_category;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $advert_region;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="adverts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $advert_user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdvertTitle(): ?string
    {
        return $this->advert_title;
    }

    public function setAdvertTitle(string $advert_title): self
    {
        $this->advert_title = $advert_title;

        return $this;
    }

    public function getAdvertPrice(): ?float
    {
        return $this->advert_price;
    }

    public function setAdvertPrice(float $advert_price): self
    {
        $this->advert_price = $advert_price;

        return $this;
    }

    public function getAdvertDescription(): ?string
    {
        return $this->advert_description;
    }

    public function setAdvertDescription(string $advert_description): self
    {
        $this->advert_description = $advert_description;

        return $this;
    }

    public function getAdvertPhoto(): ?string
    {
        return $this->advert_photo;
    }

    public function setAdvertPhoto(?string $advert_photo): self
    {
        $this->advert_photo = $advert_photo;

        return $this;
    }

    public function getAdvertDate(): ?\DateTimeInterface
    {
        return $this->advert_date;
    }

    public function setAdvertDate(): self
    {
        $now = new DateTime(date('YmdHis'));
        $this->advert_date = $now;

        return $this;
    }

    public function getAdvertLocalisation(): ?string
    {
        return $this->advert_localisation;
    }

    public function setAdvertLocalisation(string $advert_localisation): self
    {
        $this->advert_localisation = $advert_localisation;

        return $this;
    }

    public function getAdvertCategory(): ?string
    {
        return $this->advert_category;
    }

    public function setAdvertCategory(string $advert_category): self
    {
        $this->advert_category = $advert_category;

        return $this;
    }

    public function getAdvertRegion(): ?string
    {
        return $this->advert_region;
    }

    public function setAdvertRegion(string $advert_region): self
    {
        $this->advert_region = $advert_region;

        return $this;
    }

    public function getAdvertUserId(): ?user
    {
        return $this->advert_user;
    }

    public function setAdvertUserId(?user $advert_user): self
    {
        $this->advert_user = $advert_user;

        return $this;
    }
}
