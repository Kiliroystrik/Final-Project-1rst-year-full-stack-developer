<?php

namespace App\Entity;

use App\Repository\FriendListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FriendListRepository::class)]
class FriendList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToMany(targetEntity: FriendShip::class, inversedBy: 'friendLists')]
    private $friendShips;

    public function __construct()
    {
        $this->friendShips = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, FriendShip>
     */
    public function getFriendShips(): Collection
    {
        return $this->friendShips;
    }

    public function addFriendShip(FriendShip $friendShip): self
    {
        if (!$this->friendShips->contains($friendShip)) {
            $this->friendShips[] = $friendShip;
        }

        return $this;
    }

    public function removeFriendShip(FriendShip $friendShip): self
    {
        $this->friendShips->removeElement($friendShip);

        return $this;
    }
}
