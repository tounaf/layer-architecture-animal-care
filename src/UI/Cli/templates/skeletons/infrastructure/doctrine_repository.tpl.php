<?php

namespace Infrastructure\Persistence\Doctrine\Repository;

use Domain\{{ name }}\Entity\{{ name }};
use Domain\{{ name }}\Repository\{{ name }}RepositoryInterface;

final class Doctrine{{ name }}Repository implements {{ name }}RepositoryInterface
{
    public function getById(string $id): ?{{ name }}
    {
        return null; // TODO: Implémenter avec Doctrine
    }

    public function save({{ name }} ${{ variableName }}): void
    {
        // TODO: Implémenter avec Doctrine
    }
}
