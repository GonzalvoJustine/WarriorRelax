<?php

namespace App\Entity;

use App\Repository\OptionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OptionRepository::class)
 * @ORM\Table(name="`option`")
 */
class Option
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $key_option;

    /**
     * @ORM\Column(type="text")
     */
    private $value_option;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="param")
     */
    private $user;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
