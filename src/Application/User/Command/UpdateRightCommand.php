<?php

namespace Application\User\Command;

class UpdateRightCommand
{
    public function __construct(
        public string $id,
        public string $rightName,
        public string $rightCode
    ) {}
}
