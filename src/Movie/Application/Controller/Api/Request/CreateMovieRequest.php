<?php
declare (strict_types=1);

namespace App\Movie\Application\Controller\Api\Request;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateMovieRequest
{
    public function __construct(
        #[Assert\NotBlank]
        public string             $title,
        #[Assert\NotBlank]
        public \DateTimeImmutable $releaseDate,
        #[Assert\NotBlank]
        #[Assert\Range(min: 1, max: 5)]
        public int                $rating,
        #[Assert\Length(max: 1024)]
        public ?string $description = null,
    )
    {
    }
}