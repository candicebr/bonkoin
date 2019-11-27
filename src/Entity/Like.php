<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LikeRepository")
 * @ORM\Table(name="favorites")
 */
class Like
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="likes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $like_user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Advert", inversedBy="likes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $like_advert;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLikeUser(): ?User
    {
        return $this->like_user;
    }

    public function setLikeUser(?User $like_user): self
    {
        $this->like_user = $like_user;

        return $this;
    }

    public function getLikeAdvert(): ?Advert
    {
        return $this->like_advert;
    }

    public function setLikeAdvert(?Advert $like_advert): self
    {
        $this->like_advert = $like_advert;

        return $this;
    }
}
