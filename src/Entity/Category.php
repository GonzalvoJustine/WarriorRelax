<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Valid;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['read:Category:collection']],
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:Category:collection', 'read:Category:item', 'read:Category']]
        ]
    ]
)]
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:Session', 'read:Category:collection', 'read:Program', 'read:Exercise', 'read:Domains'])]
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:Session', 'read:Category:collection', 'read:Program', 'read:Exercise'])]
    private ?string $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:Session', 'read:Category:collection', 'read:Exercise'])]
    private ?string $image;

    /**
     * @ORM\ManyToMany(targetEntity=Exercise::class, inversedBy="categories")
     */
    #[
        Groups(['read:Category:item']),
        Valid()
    ]
    private Collection $exercises;

    /**
     * @ORM\ManyToMany(targetEntity=Session::class, inversedBy="categories")
     */
    #[
        Groups(['read:Category:item']),
        Valid()
    ]
    private Collection $sessions;

    /**
     * @ORM\ManyToMany(targetEntity=Program::class, inversedBy="categories")
     */
    #[
        Groups(['read:Category:item']),
        Valid()
    ]
    private Collection $programs;

    /**
     * @ORM\ManyToMany(targetEntity=Domain::class, inversedBy="categories")
     */
    #[
        Groups(['read:Category:item']),
        Valid()
    ]
    private Collection $domains;

    public function __construct()
    {
        $this->exercises = new ArrayCollection();
        $this->sessions = new ArrayCollection();
        $this->programs = new ArrayCollection();
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
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        $this->sessions->removeElement($session);

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
        }

        return $this;
    }

    public function removeProgram(Program $program): self
    {
        $this->programs->removeElement($program);

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
