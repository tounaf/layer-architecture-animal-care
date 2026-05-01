<?php

namespace Infrastructure\Security;

use Domain\User\Entity\User;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class SecurityUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    public function __construct(private User $user)
    {
    }

    public function getRoles(): array
    {
        $roles = ['ROLE_USER'];

        foreach ($this->user->getGroups() as $group) {
            foreach ($group->getRights() as $right) {
                $roles[] = 'ROLE_' . strtoupper($right->getRightCode());
            }
            foreach ($group->getProfiles() as $profile) {
                foreach ($profile->getRights() as $right) {
                    $roles[] = 'ROLE_' . strtoupper($right->getRightCode());
                }
            }
        }

        foreach ($this->user->getProfiles() as $profile) {
            foreach ($profile->getRights() as $right) {
                $roles[] = 'ROLE_' . strtoupper($right->getRightCode());
            }
        }

        foreach ($this->user->getRights() as $right) {
            $roles[] = 'ROLE_' . strtoupper($right->getRightCode());
        }

        return array_unique($roles);
    }

    public function getPassword(): ?string
    {
        return $this->user->getPassword();
    }

    public function getUsername(): string
    {
        return $this->user->getLogin();
    }

    public function getUserIdentifier(): string
    {
        return $this->user->getLogin();
    }

    public function eraseCredentials(): void
    {
    }

    public function getDomainUser(): User
    {
        return $this->user;
    }
}
