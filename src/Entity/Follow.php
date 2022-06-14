<?php

namespace App\Entity;

use App\Repository\FollowRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FollowRepository::class)]
class Follow
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: FollowList::class, inversedBy: 'follows')]
    #[ORM\JoinColumn(nullable: false)]
    private $followList;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFollowList(): ?FollowList
    {
        return $this->followList;
    }

    public function setFollowList(?FollowList $followList): self
    {
        $this->followList = $followList;

        return $this;
    }
}
