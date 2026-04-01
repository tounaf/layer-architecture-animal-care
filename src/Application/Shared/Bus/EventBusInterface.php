<?php
// src/Application/Shared/Bus/EventBusInterface.php
namespace Application\Shared\Bus;

use Domain\Shared\Event\DomainEvent;

interface EventBusInterface
{
    public function dispatch(DomainEvent $event): void;
    public function dispatchAll(array $events): void;
}
