<?php
declare (strict_types=1);

namespace App\Movie\Domain\Repository;

use App\Movie\Domain\Entity\Movie;
use Doctrine\ORM\Query;

interface MovieQueryRepositoryInterface
{
    /** @return Movie[] */
    public function findAll() : array;

    /** @param array<string, mixed> $filters */
    public function getQueryFilteredBy(array $filters) : Query;
}