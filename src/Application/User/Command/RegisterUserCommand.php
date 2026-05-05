<?php

namespace Application\User\Command;

class RegisterUserCommand
{
    public function __construct(
        public string $login,
        public string $lastname,
        public string $firstname,
        public string $mail,
        public string $password,
        public bool $isActive = true,
        public array $groupIds = [],
        public array $profileIds = [],
        public array $rightIds = []
    ) {
    }
}
