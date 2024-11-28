<?php
declare (strict_types=1);

namespace App\Movie\Infrastructure\Repository;

use App\Movie\Domain\Entity\Movie;
use App\Movie\Domain\Repository\MovieQueryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
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

    public function getQueryFilteredBy(array $filters): Query
    {
        $qb = $this->createQueryBuilder('m');

        foreach ($filters as $field => $value) {
            if ($value === null) {
                continue;
            }

            if ($value instanceof \DateTimeInterface) {
                $qb->andWhere("m.$field = :$field")
                    ->setParameter($field, $value);
                continue;
            }

            $qb->andWhere("LOWER(m.$field) LIKE LOWER(:$field)")
                ->setParameter($field, '%' . $value . '%');
        }

        return $qb->getQuery();
    }
}
