<?php
declare (strict_types=1);

namespace App\Movie\Domain\Repository;

use App\Movie\Domain\Entity\Movie;

interface MovieRepositoryInterface
{
    public function save(Movie $movie): void;

    public function delete(Movie $movie): void;
}