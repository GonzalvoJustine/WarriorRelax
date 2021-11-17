<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Valid;

/**
 * @ORM\Entity(repositoryClass=SessionRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['read:Session:collection']],
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:Session:collection', 'read:Session:item', 'read:Session']]
        ]
    ]
)]
class Session
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:User', 'read:Session:collection', 'read:Program', 'read:Category', 'read:Exercise', 'read:SessionHistory'])]
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:User', 'read:Session:collection', 'read:Program', 'read:Category', 'read:Exercise', 'read:SessionHistory'])]
    private ?string $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups(['read:User', 'read:Session:collection', 'read:Program', 'read:Category', 'read:SessionHistory'])]
    private ?string $image;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    #[Groups(['read:Session:item'])]
    private ?\DateTimeInterface $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="session")
     */
    #[
        Groups(['read:Session:item']),
        Valid()
    ]
    private ?User $user;

    /**
     * @ORM\ManyToMany(targetEntity=Exercise::class, inversedBy="sessions")
     */
    #[
        Groups(['read:Session:item']),
        Valid()
    ]
    private Collection $exercises;

    /**
     * @ORM\OneToMany(targetEntity=Program::class, mappedBy="session")
     */
    private Collection $program;

    /**
     * @ORM\ManyToOne(targetEntity=SessionHistory::class, inversedBy="sessions")
     */
    private ?SessionHistory $sessionHistory;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, mappedBy="sessions")
     */
    #[
        Groups(['read:Session:item']),
        Valid()
    ]
    private Collection $categories;

    /**
     * @ORM\ManyToOne(targetEntity=Level::class, inversedBy="sessions")
     */
    #[
        Groups(['read:Session:item']),
        Valid()
    ]
    private ?Level $level;

    /**
     * @ORM\ManyToMany(targetEntity=Domain::class, inversedBy="sessions")
     */
    #[
        Groups(['read:Session:item']),
        Valid()
    ]
    private Collection $domains;

    public function __construct()
    {
        $this->exercises = new ArrayCollection();
        $this->program = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->domains = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
        }

        return $this;
    }

    public function removeExercise(Exercise $exercise): self
    {
        $this->exercises->removeElement($exercise);

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
            $program->setSession($this);
        }

        return $this;
    }

    public function removeProgram(Program $program): self
    {
        if ($this->program->removeElement($program)) {
            // set the owning side to null (unless already changed)
            if ($program->getSession() === $this) {
                $program->setSession(null);
            }
        }

        return $this;
    }

    public function getSessionHistory(): ?SessionHistory
    {
        return $this->sessionHistory;
    }

    public function setSessionHistory(?SessionHistory $sessionHistory): self
    {
        $this->sessionHistory = $sessionHistory;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addSession($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeSession($this);
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

    /**
     * @return Collection|Domain[]
     */
    public function getDomains(): Collection
    {
        return $this->domains;
    }

    public function addDomain(Domain $domain): self
    {
        if (!$this->domains->contains($domain)) {
            $this->domains[] = $domain;
        }

        return $this;
    }

    public function removeDomain(Domain $domain): self
    {
        $this->domains->removeElement($domain);

        return $this;
    }
}
