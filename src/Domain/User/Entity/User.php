<?php

namespace Domain\User\Entity;

use Domain\Shared\Entity\AggregateRoot;
use Domain\User\ValueObject\UserId;
use Domain\User\ValueObject\ProfileId;
use Domain\User\ValueObject\GroupId;

class User extends AggregateRoot
{
    private \DateTimeImmutable $createdAt;
    private ?\DateTimeImmutable $updatedAt = null;

    private $groups;
    private $profiles;
    private $rights;

    public function __construct(
        private UserId $id,
        private string $login,
        private string $lastname,
        private string $firstname,
        private string $mail,
        private string $password,
        private bool $isActive = true
    ) {
        $this->createdAt = new \DateTimeImmutable();
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
        $this->profiles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->rights = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public static function create(
        string $login,
        string $lastname,
        string $firstname,
        string $mail,
        string $password,
        bool $isActive = true
    ): self {
        return new self(
            UserId::generate(),
            $login,
            $lastname,
            $firstname,
            $mail,
            $password,
            $isActive
        );
    }

    public function getId(): UserId { return $this->id; }
    public function getLogin(): string { return $this->login; }
    public function getLastname(): string { return $this->lastname; }
    public function getFirstname(): string { return $this->firstname; }
    public function getMail(): string { return $this->mail; }
    public function getPassword(): string { return $this->password; }

    public function updatePassword(string $hashedPassword): void
    {
        $this->password = $hashedPassword;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function updateInformation(
        string $login,
        string $lastname,
        string $firstname,
        string $mail,
        bool $isActive
    ): void {
        $this->login = $login;
        $this->lastname = $lastname;
        $this->firstname = $firstname;
        $this->mail = $mail;
        $this->isActive = $isActive;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function isActive(): bool { return $this->isActive; }
    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }
    public function getUpdatedAt(): ?\DateTimeImmutable { return $this->updatedAt; }

    public function getGroups(): array { return $this->groups->toArray(); }
    public function getProfiles(): array { return $this->profiles->toArray(); }
    public function getRights(): array { return $this->rights->toArray(); }

    public function addGroup(Group $group): void
    {
        if (!$this->groups->contains($group)) {
            $this->groups->add($group);
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function removeGroup(Group $group): void
    {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function clearGroups(): void
    {
        $this->groups->clear();
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
