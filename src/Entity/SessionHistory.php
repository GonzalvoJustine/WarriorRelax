<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SessionHistoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Valid;

/**
 * @ORM\Entity(repositoryClass=SessionHistoryRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['read:SessionHistory:collection']],
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['read:SessionHistory:collection', 'read:SessionHistory:item', 'read:SessionHistory']]
        ]
    ]
)]
class SessionHistory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:SessionHistory:collection'])]
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:SessionHistory:collection'])]
    private ?string $title;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    #[Groups(['read:SessionHistory:item'])]
    private ?\DateTimeInterface $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=Session::class, mappedBy="sessionHistory")
     */
    #[
        Groups(['read:SessionHistory:item']),
        Valid()
    ]
    private Collection $sessions;

    public function __construct()
    {
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
            $session->setSessionHistory($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getSessionHistory() === $this) {
                $session->setSessionHistory(null);
            }
        }

        return $this;
    }
}
