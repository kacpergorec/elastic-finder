<?php
declare (strict_types=1);

namespace App\Shared\Aggregate;

use App\Shared\Event\DomainEventInterface;

abstract class AggregateRoot
{
    /**
     * @var DomainEventInterface[] $domainEvents
     */
    protected array $domainEvents = [];

    final protected function raise(DomainEventInterface $event): self
    {
        $this->domainEvents[] = $event;

        return $this;
    }

    final public function pullEvents(): array
    {
        $domainEvents = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }
}