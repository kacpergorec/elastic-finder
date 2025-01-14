<?php
declare (strict_types=1);

namespace App\Shared\ValueObject;

use Symfony\Component\Uid\Uuid;

abstract class AggregateRootId
{
    protected Uuid $uuid;

    public function __construct(Uuid $uuid)
    {
        $this->uuid = $uuid;
    }

    public function toUuid(): Uuid
    {
        return $this->uuid;
    }

    public function __toString(): string
    {
        return $this->uuid->toString();
    }

    public static function new() : self
    {
        return new static(Uuid::v7());
    }
}