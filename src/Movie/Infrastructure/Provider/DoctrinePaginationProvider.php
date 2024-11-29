<?php
declare (strict_types=1);

namespace App\Movie\Infrastructure\Provider;

use App\Movie\Application\UseCase\DTO\MoviePaginatedResult;
use App\Movie\Domain\Provider\PaginatedResultInterface;
use App\Movie\Domain\Provider\PaginationProviderInterface;
use App\Movie\Domain\Repository\MovieQueryRepositoryInterface;
use App\Shared\DTO\PaginationData;
use Knp\Component\Pager\PaginatorInterface;

class DoctrinePaginationProvider implements PaginationProviderInterface
{
    public function __construct(
        public MovieQueryRepositoryInterface $movieQueryRepository,
        public PaginatorInterface            $paginator,
    )
    {
    }

    public function paginate(int $page, int $limit, array $filters = []): PaginatedResultInterface
    {
        $pagination = $this->paginator->paginate(
            target: $this->movieQueryRepository->getQueryFilteredBy($filters),
            page: $page,
            limit: $limit
        );

        return new MoviePaginatedResult(
            data: $pagination->getItems(),
            paginationData: new PaginationData(
                total: $pagination->getTotalItemCount(),
                limit: $limit,
                currentPage: $page,
                lastPage: $pagination->getPageCount()
            )
        );
    }
}