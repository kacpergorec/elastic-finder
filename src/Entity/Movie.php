<?php
declare (strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

#[Entity]
class Movie extends BaseEntity
{
    #[Column(type: 'text', nullable: true)]
    private ?string $description = null;

    public function __construct(
        #[Column(type: 'string'), NotBlank]
        private string $title,
        #[Column(type: 'integer'), Range(min: 1, max: 5)]
        private int    $rating,
        #[Column(type: 'datetime')]
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