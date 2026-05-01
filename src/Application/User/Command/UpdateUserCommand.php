<?php

namespace Application\User\Command;

class UpdateUserCommand
{
    public function __construct(
        public string $id,
        public string $login,
        public string $lastname,
        public string $firstname,
        public string $mail,
        public bool $isActive,
        public array $groups = [],
        public array $profiles = [],
        public ?string $password = null
    ) {
    }
}
