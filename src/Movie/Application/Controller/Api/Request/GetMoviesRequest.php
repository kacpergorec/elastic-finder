<?php
declare (strict_types=1);

namespace App\Movie\Application\Controller\Api\Request;

final readonly class GetMoviesRequest
{
    public function __construct(
        public ?int               $page = 1,
        public ?int               $limit = 100,
        public ?int               $rating = null,
        public ?string            $title = null,
        public ?string            $description = null,
        public ?\DateTimeImmutable $releaseDate = null,
    )
    {
    }
}