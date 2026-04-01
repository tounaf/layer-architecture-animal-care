<?php

namespace Domain\{{ name }}\Repository;

use Domain\{{ name }}\Entity\{{ name }};

interface {{ name }}RepositoryInterface
{
    public function getById(string $id): ?{{ name }};
    public function save({{ name }} ${{ variableName }}): void;
}
