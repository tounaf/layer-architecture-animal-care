<?php

namespace Application\User\Command;

class DeleteProfileCommand
{
    public function __construct(public string $id) {}
}
