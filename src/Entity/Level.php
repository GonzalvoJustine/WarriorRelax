<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LevelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=LevelRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['read:Level:collection']],
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:Level:collection', 'read:Level:item']]
        ]
    ]
)]
class Level
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:User', 'read:Level:collection', 'read:Session', 'read:Program', 'read:Exercise', 'read:Avatar'])]
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:User', 'read:Level:collection', 'read:Session', 'read:Program', 'read:Exercise', 'read:Avatar'])]
    private ?string $name;

    /**
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:User', 'read:Level:item'])]
    private ?int $level;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="level")
     */
    private Collection $users;

    /**
     * @ORM\OneToMany(targetEntity=Exercise::class, mappedBy="level")
     */
    private Collection $exercises;

    /**
     * @ORM\OneToMany(targetEntity=Session::class, mappedBy="level")
     */
    private Collection $sessions;

    /**
     * @ORM\OneToMany(targetEntity=Program::class, mappedBy="level")
     */
    private Collection $programs;

    /**
     * @ORM\OneToMany(targetEntity=Avatar::class, mappedBy="level")
     */
    private Collection $avatars;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->exercises = new ArrayCollection();
        $this->sessions = new ArrayCollection();
        $this->programs = new ArrayCollection();
        $this->avatars = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

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
            $user->setLevel($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getLevel() === $this) {
                $user->setLevel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Exercise[]
     */
    public function getExercises(): Collection
    {
        return $this->exercises;
    }

    public function addExercise(Exercise $exercise): self
    {
        if (!$this->exercises->contains($exercise)) {
            $this->exercises[] = $exercise;
            $exercise->setLevel($this);
        }

        return $this;
    }

    public function removeExercise(Exercise $exercise): self
    {
        if ($this->exercises->removeElement($exercise)) {
            // set the owning side to null (unless already changed)
            if ($exercise->getLevel() === $this) {
                $exercise->setLevel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Session[]
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): self
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions[] = $session;
            $session->setLevel($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getLevel() === $this) {
                $session->setLevel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Program[]
     */
    public function getPrograms(): Collection
    {
        return $this->programs;
    }

    public function addProgram(Program $program): self
    {
        if (!$this->programs->contains($program)) {
            $this->programs[] = $program;
            $program->setLevel($this);
        }

        return $this;
    }

    public function removeProgram(Program $program): self
    {
        if ($this->programs->removeElement($program)) {
            // set the owning side to null (unless already changed)
            if ($program->getLevel() === $this) {
                $program->setLevel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Avatar[]
     */
    public function getAvatars(): Collection
    {
        return $this->avatars;
    }

    public function addAvatar(Avatar $avatar): self
    {
        if (!$this->avatars->contains($avatar)) {
            $this->avatars[] = $avatar;
            $avatar->setLevel($this);
        }

        return $this;
    }

    public function removeAvatar(Avatar $avatar): self
    {
        if ($this->avatars->removeElement($avatar)) {
            // set the owning side to null (unless already changed)
            if ($avatar->getLevel() === $this) {
                $avatar->setLevel(null);
            }
        }

        return $this;
    }
}
