<?php
declare (strict_types=1);

namespace App\Shared\ValueObject;

use Symfony\Component\Uid\Uuid;

abstract class AggregateRootId
{
    protected Uuid $uuid;

    public function __construct(string $uuid)
    {
        if (!Uuid::isValid($uuid)) {
            throw new \InvalidArgumentException('Invalid UUID');
        }

        $this->uuid = Uuid::fromString($uuid);
    }

    public function getValue(): Uuid
    {
        return $this->uuid;
    }

    public function __toString(): string
    {
        return $this->uuid->toString();
    }
}