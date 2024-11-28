<?php
declare (strict_types=1);

namespace App\Movie\Application\Service;

use App\Movie\Application\Model\FindMoviesQuery;
use App\Movie\Domain\Entity\Movie;
use App\Movie\Domain\Repository\MovieQueryRepositoryInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetMoviesHandler
{
    public function __construct(
        public MovieQueryRepositoryInterface $movieQueryRepository,
        public PaginatorInterface                     $paginator
    )
    {
    }

    /**
     * @return Movie[]
     */
    public function __invoke(FindMoviesQuery $query): PaginationInterface
    {
        return $this->paginator->paginate(
            target: $this->movieQueryRepository->getQueryFilteredBy([
                'title' => $query->title,
                'description' => $query->description,
                'rating' => $query->rating,
                'releaseDate' => $query->releaseDate,
            ]),
            page: $query->page,
            limit: $query->limit
        );
    }
}