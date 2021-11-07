<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DomainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Valid;

/**
 * @ORM\Entity(repositoryClass=DomainRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['read:Domains:collection']],
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:Domains:collection', 'read:Domains:item', 'read:Domains']]
        ]
    ]
)]
class Domain
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:Domains:collection'])]
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:Domains:collection'])]
    private ?string $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:Domains:collection'])]
    private ?string $image;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, mappedBy="domains")
     */
    #[
        Groups(['read:Domains:item']),
        Valid()
    ]
    private Collection $categories;

    /**
     * @ORM\ManyToMany(targetEntity=Exercise::class, mappedBy="domains")
     */
    #[
        Groups(['read:Domains:item']),
        Valid()
    ]
    private Collection $exercises;

    /**
     * @ORM\ManyToMany(targetEntity=Session::class, mappedBy="domains")
     */
    #[
        Groups(['read:Domains:item']),
        Valid()
    ]
    private Collection $sessions;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->exercises = new ArrayCollection();
        $this->sessions = new ArrayCollection();
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
            $category->addDomain($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeDomain($this);
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
            $exercise->addDomain($this);
        }

        return $this;
    }

    public function removeExercise(Exercise $exercise): self
    {
        if ($this->exercises->removeElement($exercise)) {
            $exercise->removeDomain($this);
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
            $session->addDomain($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->sessions->removeElement($session)) {
            $session->removeDomain($this);
        }

        return $this;
    }
}
