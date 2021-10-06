<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CartRepository::class)
 */
class Cart
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
    private ?string $title;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $total_exercise;

    /**
     * @ORM\ManyToOne(targetEntity=Exercise::class, inversedBy="carts")
     */
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
