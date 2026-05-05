<?php

namespace Application\User\Command;

class CreateProfileCommand
{
    public function __construct(
        public string $profileName,
        public array $rightIds = []
    ) {}
}
