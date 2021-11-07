<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=OptionRepository::class)
 * @ORM\Table(name="`option`")
 */
#[ApiResource(
    normalizationContext: ['groups' => ['read:Option:collection']],
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:Option:collection']]
        ]
    ]
)]
class Option
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:User', 'read:Option:collection'])]
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:User', 'read:Option:collection'])]
    private ?string $key_option;

    /**
     * @ORM\Column(type="text")
     */
    #[Groups(['read:User', 'read:Option:collection'])]
    private ?string $value_option;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="parameter")
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

    public function getKeyOption(): ?string
    {
        return $this->key_option;
    }

    public function setKeyOption(string $key_option): self
    {
        $this->key_option = $key_option;

        return $this;
    }

    public function getValueOption(): ?string
    {
        return $this->value_option;
    }

    public function setValueOption(string $value_option): self
    {
        $this->value_option = $value_option;

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
            $user->setParameter($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getParameter() === $this) {
                $user->setParameter(null);
            }
        }

        return $this;
    }
}
