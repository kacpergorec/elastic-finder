<?php
declare (strict_types=1);

namespace App\Movie\Application\UseCase\Handler;

use App\Movie\Application\UseCase\Query\FindMoviesQuery;
use App\Movie\Domain\Entity\Movie;
use App\Movie\Domain\Provider\PaginatedResultInterface;
use App\Movie\Domain\Provider\PaginationProviderInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetMoviesHandler
{
    public function __construct(
        public PaginationProviderInterface $paginationProvider
    )
    {
    }

    public function __invoke(FindMoviesQuery $query): PaginatedResultInterface
    {
        return $this->paginationProvider->paginate(
            page: $query->page,
            limit: $query->limit,
            filters: [
                'title' => $query->title,
                'description' => $query->description,
                'rating' => $query->rating,
                'releaseDate' => $query->releaseDate,
            ]);
    }
}