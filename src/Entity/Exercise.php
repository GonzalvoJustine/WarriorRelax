<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ExerciseRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Valid;

/**
 * @ORM\Entity(repositoryClass=ExerciseRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['read:Exercise:collection']],
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:Exercise:collection', 'read:Exercise:item', 'read:Exercise']]
        ]
    ]
)]
class Exercise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:User', 'read:Exercise:collection', 'read:Session', 'read:Category', 'read:Cart'])]
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:User', 'read:Exercise:collection', 'read:Session', 'read:Category', 'read:Cart'])]
    private ?string $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups(['read:Exercise:item'])]
    private ?string $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups(['read:Exercise:item'])]
    private ?string $indication;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups(['read:Exercise:collection', 'read:Session', 'read:Category'])]
    private ?string $image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups(['read:Exercise:item', 'read:Session'])]
    private ?string $media;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    #[Groups(['read:Exercise:item'])]
    private \DateTime $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="exercise")
     */
    private ?User $user;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, mappedBy="exercises")
     */
    #[
        Groups(['read:Exercise:item']),
        Valid()
    ]
    private Collection $categories;

    /**
     * @ORM\ManyToOne(targetEntity=Level::class, inversedBy="exercises")
     */
    #[
        Groups(['read:Exercise:item']),
        Valid()
    ]
    private ?Level $level;

    /**
     * @ORM\ManyToMany(targetEntity=Domain::class, inversedBy="exercises")
     */
    private $domains;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->carts = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIndication(): ?string
    {
        return $this->indication;
    }

    public function setIndication(?string $indication): self
    {
        $this->indication = $indication;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getMedia(): ?string
    {
        return $this->media;
    }

    public function setMedia(?string $media): self
    {
        $this->media = $media;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
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
            $category->addExercise($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeExercise($this);
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
