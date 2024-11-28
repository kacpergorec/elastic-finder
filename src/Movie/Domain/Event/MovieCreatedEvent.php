<?php
declare (strict_types=1);

namespace App\Movie\Domain\Event;

use App\Movie\Domain\Entity\MovieId;
use App\Shared\Event\DomainEventInterface;

final readonly class MovieCreatedEvent implements DomainEventInterface
{
    protected \DateTimeImmutable $occurredOn;

    public function __construct(
        protected MovieId $movieId,
    )
    {
        $this->occurredOn = new \DateTimeImmutable();
    }

}