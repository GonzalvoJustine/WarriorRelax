<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CartRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Valid;

/**
 * @ORM\Entity(repositoryClass=CartRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['read:Cart:collection']],
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:Cart:collection', 'read:Cart:item', 'read:Cart']]
        ]
    ]
)]
class Cart
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:Exercise', 'read:Cart:collection'])]
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:Exercise', 'read:Cart:collection'])]
    private ?string $title;

    /**
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:Cart:item'])]
    private ?int $total_exercise;

    /**
     * @ORM\ManyToOne(targetEntity=Exercise::class, inversedBy="carts")
     */
    #[
        Groups(['read:Cart:item']),
        Valid()
    ]
    private ?Exercise $exercises;

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

    public function getTotalExercise(): ?int
    {
        return $this->total_exercise;
    }

    public function setTotalExercise(int $total_exercise): self
    {
        $this->total_exercise = $total_exercise;

        return $this;
    }

    public function getExercises(): ?Exercise
    {
        return $this->exercises;
    }

    public function setExercises(?Exercise $exercises): self
    {
        $this->exercises = $exercises;

        return $this;
    }
}
