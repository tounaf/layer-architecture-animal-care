<?php

namespace Application\User\Command;

class UpdateProfileCommand
{
    public function __construct(
        public string $id,
        public string $profileName,
        public array $rightIds = []
    ) {}
}
