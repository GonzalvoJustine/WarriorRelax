<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AvatarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Valid;

/**
 * @ORM\Entity(repositoryClass=AvatarRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['read:Avatar:collection']],
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:Avatar:collection', 'read:Avatar:item', 'read:Avatar']]
        ]
    ]
)]
class Avatar
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:User', 'read:Avatar:collection'])]
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:User', 'read:Avatar:collection'])]
    private ?string $image;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="avatar")
     */
    private Collection $users;

    /**
     * @ORM\ManyToOne(targetEntity=Level::class, inversedBy="avatars")
     */
    #[
        Groups(['read:Avatar:item']),
        Valid()
    ]
    private ?Level $level;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addAvatar($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeAvatar($this);
        }

        return $this;
    }

    public function getLevel(): ?Level
    {
        return $this->level;
    }

    public function setLevel(?Level $level): self
    {
        $this->level = $level;

        return $this;
    }
}
