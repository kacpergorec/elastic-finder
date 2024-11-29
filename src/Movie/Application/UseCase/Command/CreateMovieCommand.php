<?php
declare (strict_types=1);

namespace App\Movie\Application\UseCase\Command;

final readonly class CreateMovieCommand
{
    public function __construct(
        public string $title,
        public \DateTimeImmutable $releaseDate,
        public int $rating,
        public ?string $description = null
    )
    {
    }
}