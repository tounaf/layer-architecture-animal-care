<?php

namespace Application\User\Command;

class CreateRightCommand
{
    public function __construct(
        public string $rightName,
        public string $rightCode
    ) {}
}
