<?php

namespace Domain\User\Entity;

use Domain\Shared\Entity\AggregateRoot;
use Domain\User\ValueObject\ProfileId;

class Profile extends AggregateRoot
{
    private \DateTimeImmutable $createdAt;
    private ?\DateTimeImmutable $updatedAt = null;

    private $rights;

    public function __construct(
        private ProfileId $id,
        private string $profileName
    ) {
        $this->createdAt = new \DateTimeImmutable();
        $this->rights = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public static function create(string $profileName): self
    {
        return new self(ProfileId::generate(), $profileName);
    }

    public function getId(): ProfileId { return $this->id; }
    public function getProfileName(): string { return $this->profileName; }
    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }
    public function getUpdatedAt(): ?\DateTimeImmutable { return $this->updatedAt; }
    public function getRights(): array { return $this->rights->toArray(); }

    public function updateInformation(string $profileName): void
    {
        $this->profileName = $profileName;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function addRight(Right $right): void
    {
        if (!$this->rights->contains($right)) {
            $this->rights->add($right);
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function removeRight(Right $right): void
    {
        if ($this->rights->contains($right)) {
            $this->rights->removeElement($right);
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function clearRights(): void
    {
        $this->rights->clear();
        $this->updatedAt = new \DateTimeImmutable();
    }
}
