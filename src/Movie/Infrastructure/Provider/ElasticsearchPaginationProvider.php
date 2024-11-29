<?php
declare (strict_types=1);

namespace App\Movie\Infrastructure\Provider;

use App\Movie\Application\UseCase\DTO\MoviePaginatedResult;
use App\Movie\Domain\Provider\PaginatedResultInterface;
use App\Movie\Domain\Provider\PaginationProviderInterface;
use App\Shared\DTO\PaginationData;
use Elastica\Aggregation\DateRange;
use Elastica\Query;
use Elastica\Query\BoolQuery;
use Elastica\Query\Fuzzy;
use Elastica\Query\Term;
use Elastica\Query\Terms;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

readonly class ElasticsearchPaginationProvider implements PaginationProviderInterface
{
    public function __construct(
        private PaginatedFinderInterface $finder,
        private PaginatorInterface $paginator,
    )
    {
    }

    public function paginate(int $page, int $limit, array $filters = []): PaginatedResultInterface
    {
        $boolQuery = new BoolQuery();

        foreach (array_filter($filters) as $key => $value) {
            if (is_array($value)) {
                $boolQuery->addMust(new Terms($key, $value));
                continue;
            }

            if (is_numeric($value)) {
                $boolQuery->addMust(new Term([$key => $value]));
                continue;
            }

            if ($value instanceof \DateTimeInterface){
                $boolQuery->addMust(new Query\MatchQuery($key, $value->format('Y-m-d')));

                continue;
            }

            $boolQuery->addMust(new Query\MatchQuery($key, $value));
        }
        $query = new Query($boolQuery);

        $results = $this->finder->createPaginatorAdapter($query);
        $pagination = $this->paginator->paginate($results, $page, $limit);

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