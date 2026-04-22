<?php

namespace Infrastructure\Persistence\Doctrine\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Domain\Animal\Entity\Animal;
use Domain\Client\Entity\Client;

class ClientAnimalFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $clientsData = [
            ['Rakotondrazaka', 'Hery', '034 12 345 67', 'Antananarivo', 'hery@gmail.com'],
            ['Randrianarison', 'Miora', '033 98 765 43', 'Antananarivo', 'miora@mail.com'],
            ['Rajoelina', 'Faly', '032 45 678 90', 'Antananarivo', 'faly@test.com'],
        ];

        $clients = [];
        foreach ($clientsData as $data) {
            $client = Client::creer($data[0], $data[1], $data[4], $data[2], $data[3]);
            $manager->persist($client);
            $clients[$data[0]] = $client;
        }

        $animalsData = [
            ['Médor', 'chien', 'Berger malgache', '10/05/2020', 'Rakotondrazaka', 25.5],
            ['Kitty', 'chat', 'Européen', '15/03/2022', 'Rakotondrazaka', 4.2],
            ['Loulou', 'chien', 'Caniche', '22/08/2021', 'Randrianarison', 8.0],
            ['Coco', 'nac', 'Perroquet', '30/11/2019', 'Rajoelina', 0.8],
        ];

        foreach ($animalsData as $data) {
            $animal = Animal::creer(
                $data[0],
                $data[1],
                $data[2],
                \DateTimeImmutable::createFromFormat('d/m/Y', $data[3]),
                $clients[$data[4]]->getId(),
                $data[5]
            );
            $manager->persist($animal);
        }

        $manager->flush();
    }
}
