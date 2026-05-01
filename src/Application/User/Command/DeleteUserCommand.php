<?php

namespace Application\User\Command;

class DeleteUserCommand
{
    public function __construct(
        public string $id
    ) {
    }
}
