<?php
declare(strict_types=1);

namespace App\Movie\Domain\Entity;

use Symfony\Component\Uid\Uuid;

final class Movie
{
    public readonly Uuid $id;

    private ?string $description = null;

    public function __construct(
        private string             $title,
        private int                $rating,
        private \DateTimeInterface $releaseDate
    )
    {
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
