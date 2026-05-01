<?php

namespace Infrastructure\Persistence\Doctrine\Fixtures;

use Domain\User\Entity\User;
use Domain\User\Entity\Right;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Infrastructure\Security\SecurityUser;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $adminRight = Right::create('Administration', 'admin');
        $manager->persist($adminRight);

        $user = User::create(
            'admin',
            'Admin',
            'System',
            'admin@example.com',
            ''
        );
        $user->addRight($adminRight);

        $securityUser = new SecurityUser($user);
        $hashedPassword = $this->passwordHasher->hashPassword($securityUser, 'admin');

        $reflection = new \ReflectionClass($user);
        $property = $reflection->getProperty('password');
        $property->setAccessible(true);
        $property->setValue($user, $hashedPassword);

        $manager->persist($user);
        $manager->flush();
    }
}
