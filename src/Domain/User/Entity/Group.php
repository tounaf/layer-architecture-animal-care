<?php

namespace Domain\User\Entity;

use Domain\Shared\Entity\AggregateRoot;
use Domain\User\ValueObject\GroupId;

class Group extends AggregateRoot
{
    private \DateTimeImmutable $createdAt;
    private ?\DateTimeImmutable $updatedAt = null;

    private $rights;
    private $profiles;

    public function __construct(
        private GroupId $id,
        private string $groupName
    ) {
        $this->createdAt = new \DateTimeImmutable();
        $this->rights = new \Doctrine\Common\Collections\ArrayCollection();
        $this->profiles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public static function create(string $groupName): self
    {
        return new self(GroupId::generate(), $groupName);
    }

    public function getId(): GroupId { return $this->id; }
    public function getGroupName(): string { return $this->groupName; }
    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }
    public function getUpdatedAt(): ?\DateTimeImmutable { return $this->updatedAt; }
    public function getRights(): array { return $this->rights->toArray(); }
    public function getProfiles(): array { return $this->profiles->toArray(); }

    public function updateInformation(string $groupName): void
    {
        $this->groupName = $groupName;
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

    public function addProfile(Profile $profile): void
    {
        if (!$this->profiles->contains($profile)) {
            $this->profiles->add($profile);
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function removeProfile(Profile $profile): void
    {
        if ($this->profiles->contains($profile)) {
            $this->profiles->removeElement($profile);
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function clearProfiles(): void
    {
        $this->profiles->clear();
        $this->updatedAt = new \DateTimeImmutable();
    }
}
