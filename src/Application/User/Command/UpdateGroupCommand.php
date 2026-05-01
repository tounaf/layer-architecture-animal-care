<?php

namespace Application\User\Command;

class UpdateGroupCommand
{
    public function __construct(
        public string $id,
        public string $groupName,
        public array $rightIds = [],
        public array $profileIds = []
    ) {}
}
