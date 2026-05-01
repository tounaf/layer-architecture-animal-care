<?php

namespace Application\User\Command;

class DeleteGroupCommand
{
    public function __construct(public string $id) {}
}
