<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $username;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 50)]
    private $firstName;

    #[ORM\Column(type: 'string', length: 50)]
    private $lastName;

    #[ORM\Column(type: 'date')]
    private $birthDate;

    #[ORM\Column(type: 'string', length: 10)]
    private $gender;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $mood;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $avatar;

    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Post::class, orphanRemoval: true)]
    private $posts;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Comment::class, orphanRemoval: true)]
    private $comments;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: LikePost::class, orphanRemoval: true)]
    private $likePosts;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: LikeComment::class, orphanRemoval: true)]
    private $likeComments;

    #[ORM\OneToOne(targetEntity: FriendList::class, cascade: ['persist', 'remove'])]
    private $friends;

    #[ORM\OneToOne(targetEntity: FollowList::class, cascade: ['persist', 'remove'])]
    private $follows;

    #[ORM\Column(type: 'string', length: 100)]
    private $email;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->likePosts = new ArrayCollection();
        $this->likeComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getMood(): ?string
    {
        return $this->mood;
    }

    public function setMood(?string $mood): self
    {
        $this->mood = $mood;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setUser($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LikePost>
     */
    public function getLikePosts(): Collection
    {
        return $this->likePosts;
    }

    public function addLikePost(LikePost $likePost): self
    {
        if (!$this->likePosts->contains($likePost)) {
            $this->likePosts[] = $likePost;
            $likePost->setUser($this);
        }

        return $this;
    }

    public function removeLikePost(LikePost $likePost): self
    {
        if ($this->likePosts->removeElement($likePost)) {
            // set the owning side to null (unless already changed)
            if ($likePost->getUser() === $this) {
                $likePost->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LikeComment>
     */
    public function getLikeComments(): Collection
    {
        return $this->likeComments;
    }

    public function addLikeComment(LikeComment $likeComment): self
    {
        if (!$this->likeComments->contains($likeComment)) {
            $this->likeComments[] = $likeComment;
            $likeComment->setUser($this);
        }

        return $this;
    }

    public function removeLikeComment(LikeComment $likeComment): self
    {
        if ($this->likeComments->removeElement($likeComment)) {
            // set the owning side to null (unless already changed)
            if ($likeComment->getUser() === $this) {
                $likeComment->setUser(null);
            }
        }

        return $this;
    }

    public function getFriends(): ?FriendList
    {
        return $this->friends;
    }

    public function setFriends(?FriendList $friends): self
    {
        $this->friends = $friends;

        return $this;
    }

    public function getFollows(): ?FollowList
    {
        return $this->follows;
    }

    public function setFollows(?FollowList $follows): self
    {
        $this->follows = $follows;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
