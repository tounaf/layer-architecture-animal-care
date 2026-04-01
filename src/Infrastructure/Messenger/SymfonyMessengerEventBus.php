<?php
// src/Infrastructure/Messenger/SymfonyMessengerEventBus.php
namespace Infrastructure\Messenger;

use Application\Shared\Bus\EventBusInterface;
use Domain\Shared\Event\DomainEvent;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

final readonly class SymfonyMessengerEventBus implements EventBusInterface
{
    public function __construct(
        private MessageBusInterface $eventBus
    ) {}

    public function dispatch(DomainEvent $event): void
    {
        $this->eventBus->dispatch($event, [new DispatchAfterCurrentBusStamp()]);
    }

    public function dispatchAll(array $events): void
    {
        foreach ($events as $event) {
            $this->dispatch($event);
        }
    }
}
