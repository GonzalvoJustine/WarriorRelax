<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProgramRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Valid;

/**
 * @ORM\Entity(repositoryClass=ProgramRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['read:Program:collection']],
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:Program:collection', 'read:Program:item', 'read:Program']]
        ]
    ]
)]
class Program
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:User', 'read:Program:collection', 'read:Category'])]
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:User', 'read:Program:collection', 'read:Category'])]
    private ?string $title;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    #[Groups(['read:Program:item'])]
    private ?\DateTimeInterface $date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    #[Groups(['read:Program:item'])]
    private ?int $repeat_program;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    #[Groups(['read:Program:item'])]
    private ?\DateTimeInterface $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="program")
     */
    #[
        Groups(['read:Program:item']),
        Valid()
    ]
    private ?User $user;

    /**
     * @ORM\ManyToOne(targetEntity=Session::class, inversedBy="program")
     */
    #[
        Groups(['read:Program:item']),
        Valid()
    ]
    private ?Session $session;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, mappedBy="programs")
     */
    #[
        Groups(['read:Program:item']),
        Valid()
    ]
    private Collection $categories;

    /**
     * @ORM\ManyToOne(targetEntity=Level::class, inversedBy="programs")
     */
    #[
        Groups(['read:Program:item']),
        Valid()
    ]
    private ?Level $level;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getRepeatProgram(): ?int
    {
        return $this->repeat_program;
    }

    public function setRepeatProgram(?int $repeat_program): self
    {
        $this->repeat_program = $repeat_program;

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

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): self
    {
        $this->session = $session;

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
            $category->addProgram($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeProgram($this);
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
