<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $key_tag;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $value_tag;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="tag")
     */
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKeyTag(): ?string
    {
        return $this->key_tag;
    }

    public function setKeyTag(string $key_tag): self
    {
        $this->key_tag = $key_tag;

        return $this;
    }

    public function getValueTag(): ?string
    {
        return $this->value_tag;
    }

    public function setValueTag(string $value_tag): self
    {
        $this->value_tag = $value_tag;

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
            $user->setTag($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getTag() === $this) {
                $user->setTag(null);
            }
        }

        return $this;
    }

}
