<?php
declare (strict_types=1);

namespace App\Movie\Application\UseCase\Query;

use App\Movie\Application\Controller\Api\Request\GetMoviesRequest;

final readonly class FindMoviesQuery
{
    public function __construct(
        public int       $page,
        public int       $limit,
        public ?string    $title = null,
        public ?string    $description = null,
        public ?int       $rating = null,
        public ?\DateTimeImmutable $releaseDate = null,
    )
    {
    }

    public static function fromRequest(?GetMoviesRequest $request): self
    {
        return new self(
            page: $request->page,
            limit: $request->limit,
            title: $request->title,
            description: $request->description,
            rating: $request->rating,
            releaseDate: $request->releaseDate
        );
    }
}