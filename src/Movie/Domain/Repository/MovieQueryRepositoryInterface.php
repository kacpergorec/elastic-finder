<?php
declare (strict_types=1);

namespace App\Movie\Domain\Repository;

use App\Movie\Domain\Entity\Movie;

interface MovieQueryRepositoryInterface
{
    /** @return Movie[] */
    public function findAll() : array;
}