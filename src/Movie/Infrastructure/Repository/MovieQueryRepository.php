<?php
declare (strict_types=1);

namespace App\Movie\Infrastructure\Repository;

use App\Movie\Domain\Entity\Movie;
use App\Movie\Domain\Repository\MovieQueryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Movie>
 */
final class MovieQueryRepository extends ServiceEntityRepository implements MovieQueryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }
}
