<?php

namespace App\Entity;

use App\Repository\FriendShipRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FriendShipRepository::class)]
class FriendShip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToMany(targetEntity: FriendList::class, mappedBy: 'friendShips')]
    private $friendLists;

    public function __construct()
    {
        $this->friendLists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, FriendList>
     */
    public function getFriendLists(): Collection
    {
        return $this->friendLists;
    }

    public function addFriendList(FriendList $friendList): self
    {
        if (!$this->friendLists->contains($friendList)) {
            $this->friendLists[] = $friendList;
            $friendList->addFriendShip($this);
        }

        return $this;
    }

    public function removeFriendList(FriendList $friendList): self
    {
        if ($this->friendLists->removeElement($friendList)) {
            $friendList->removeFriendShip($this);
        }

        return $this;
    }
}
