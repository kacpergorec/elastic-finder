<?php
declare (strict_types=1);

namespace App\Movie\Application\Event;

readonly class OnMovieCreationRequestEvent
{
    public function __construct(
        public string             $title,
        public \DateTimeImmutable $releaseDate,
        public int                $rating,
        public ?string             $description = null,
    )
    {
    }
}