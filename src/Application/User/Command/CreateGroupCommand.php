<?php

namespace Application\User\Command;

class CreateGroupCommand
{
    public function __construct(
        public string $groupName,
        public array $rightIds = [],
        public array $profileIds = []
    ) {}
}
