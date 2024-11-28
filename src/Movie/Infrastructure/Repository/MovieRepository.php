<?php
declare (strict_types=1);

namespace App\Movie\Infrastructure\Repository;

use App\Movie\Domain\Entity\Movie;
use App\Movie\Domain\Repository\MovieRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<Movie>
 */
final class MovieRepository extends ServiceEntityRepository implements MovieRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    public function save(Movie $movie): void
    {
        $this->getEntityManager()->persist($movie);
        $this->getEntityManager()->flush();
    }

    public function delete(Movie $movie): void
    {
        $this->getEntityManager()->remove($movie);
        $this->getEntityManager()->flush();
    }
}
