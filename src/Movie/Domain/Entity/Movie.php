<?php
declare(strict_types=1);

namespace App\Movie\Domain\Entity;

use App\Movie\Domain\Event\MovieCreatedEvent;
use App\Shared\Aggregate\AggregateRoot;
use Symfony\Component\Uid\Uuid;

final class Movie extends AggregateRoot
{
    private ?string $description = null;

    public function __construct(
        private Uuid               $id,
        private string             $title,
        private int                $rating,
        private \DateTimeInterface $releaseDate
    )
    {
    }

    public static function create(
        MovieId            $id,
        string             $title,
        int                $rating,
        \DateTimeImmutable $releaseDate
    ): self
    {
        $document = new self($id->toUuid(), $title, $rating, $releaseDate);
        $document->raise(new MovieCreatedEvent($id));

        return $document;
    }

    public function getId(): MovieId
    {
        return new MovieId($this->id);
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function setRating(int $rating): void
    {
        $this->rating = $rating;
    }

    public function getReleaseDate(): \DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTimeInterface $releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }
}
