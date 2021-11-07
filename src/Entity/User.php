<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Valid;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="Il y a déjà un compte avec cette adresse mail")
 */
#[ApiResource(
    normalizationContext: ['groups' => ['read:User:collection']],
    denormalizationContext: ['groups' => ['put:User']],
    itemOperations: [
        'put',
        'get' => [
            'normalization_context' => ['groups' => ['read:User:collection', 'read:User:item', 'read:User']]
        ]
    ]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:User:collection', 'read:Session', 'read:Program'])]
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    #[Groups(['read:User:item', 'put:User'])]
    private ?string $email;

    /**
     * @ORM\Column(type="json")
     */
    #[Groups(['read:User:item', 'read:Session'])]
    private mixed $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    #[Groups(['read:User:item', 'put:User'])]
    private string $password;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    #[Groups(['read:User:item', 'put:User'])]
    private ?string $gender;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    #[Groups(['read:User:collection', 'put:User', 'read:Session', 'read:Program'])]
    private ?string $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups(['read:User:item', 'put:User'])]
    private ?string $lastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups(['read:User:item', 'put:User'])]
    private ?string $firstname;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    #[Groups(['read:User:item', 'put:User'])]
    private ?\DateTimeInterface $birthday;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    #[Groups(['read:User:item'])]
    private ?\DateTimeInterface $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity=Avatar::class, inversedBy="users", cascade={"persist"})
     */
    #[
        Groups(['read:User:item', 'put:User']),
        Valid()
    ]
    private Collection $avatar;

    /**
     * @ORM\OneToMany(targetEntity=Exercise::class, mappedBy="user", cascade={"persist"})
     */
    #[
        Groups(['read:User:item']),
        Valid()
    ]
    private Collection $exercise;

    /**
     * @ORM\OneToMany(targetEntity=Session::class, mappedBy="user", cascade={"persist"})
     */
    #[
        Groups(['read:User:item']),
        Valid()
    ]
    private Collection $session;

    /**
     * @ORM\OneToMany(targetEntity=Program::class, mappedBy="user", cascade={"persist"})
     */
    #[
        Groups(['read:User:item']),
        Valid()
    ]
    private Collection $program;

    /**
     * @ORM\ManyToOne(targetEntity=Tag::class, inversedBy="users", cascade={"persist"})
     */
    #[
        Groups(['read:User:item']),
        Valid()
    ]
    private ?Tag $tag;

    /**
     * @ORM\ManyToOne(targetEntity=Level::class, inversedBy="users", cascade={"persist"})
     */
    #[
        Groups(['read:User:item']),
        Valid()
    ]
    private ?Level $level;

    /**
     * @ORM\ManyToOne(targetEntity=Option::class, inversedBy="users", cascade={"persist"})
     */
    #[
        Groups(['read:User:item', 'put:User']),
        Valid()
    ]
    private ?Option $parameter;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isVerified = false;

    public function __construct()
    {
        $this->avatar = new ArrayCollection();
        $this->exercise = new ArrayCollection();
        $this->session = new ArrayCollection();
        $this->program = new ArrayCollection();
        $this->roles = ['ROLE_USER'];
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
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

    /**
     * @param array<mixed> $roles
     * @return $this
     */
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
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|Avatar[]
     */
    public function getAvatar(): Collection
    {
        return $this->avatar;
    }

    public function addAvatar(Avatar $avatar): self
    {
        if (!$this->avatar->contains($avatar)) {
            $this->avatar[] = $avatar;
        }

        return $this;
    }

    public function removeAvatar(Avatar $avatar): self
    {
        $this->avatar->removeElement($avatar);

        return $this;
    }

    /**
     * @return Collection|Exercise[]
     */
    public function getExercise(): Collection
    {
        return $this->exercise;
    }

    public function addExercise(Exercise $exercise): self
    {
        if (!$this->exercise->contains($exercise)) {
            $this->exercise[] = $exercise;
            $exercise->setUser($this);
        }

        return $this;
    }

    public function removeExercise(Exercise $exercise): self
    {
        if ($this->exercise->removeElement($exercise)) {
            // set the owning side to null (unless already changed)
            if ($exercise->getUser() === $this) {
                $exercise->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Session[]
     */
    public function getSession(): Collection
    {
        return $this->session;
    }

    public function addSession(Session $session): self
    {
        if (!$this->session->contains($session)) {
            $this->session[] = $session;
            $session->setUser($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->session->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getUser() === $this) {
                $session->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Program[]
     */
    public function getProgram(): Collection
    {
        return $this->program;
    }

    public function addProgram(Program $program): self
    {
        if (!$this->program->contains($program)) {
            $this->program[] = $program;
            $program->setUser($this);
        }

        return $this;
    }

    public function removeProgram(Program $program): self
    {
        if ($this->program->removeElement($program)) {
            // set the owning side to null (unless already changed)
            if ($program->getUser() === $this) {
                $program->setUser(null);
            }
        }

        return $this;
    }

    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    public function setTag(?Tag $tag): self
    {
        $this->tag = $tag;

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

    public function getParameter(): ?Option
    {
        return $this->parameter;
    }

    public function setParameter(?Option $parameter): self
    {
        $this->parameter = $parameter;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
