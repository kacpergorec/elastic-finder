<?php
declare (strict_types=1);

namespace App\Movie\Infrastructure\Provider;

use App\Movie\Application\UseCase\DTO\MoviePaginatedResult;
use App\Movie\Domain\Provider\PaginatedResultInterface;
use App\Movie\Domain\Provider\PaginationProviderInterface;
use App\Shared\DTO\PaginationData;
use Elastica\Query;
use Elastica\Query\BoolQuery;
use Elastica\Query\Fuzzy;
use Elastica\Query\Term;
use Elastica\Query\Terms;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;

readonly class ElasticsearchPaginationProvider implements PaginationProviderInterface
{
    public function __construct(
        private PaginatedFinderInterface $finder,
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
                dump($value->format('Y-m-d'));
                $boolQuery->addMust(new Term([$key => $value->format('Y-m-d')]));
                continue;
            }

            $boolQuery->addMust(new Query\MatchQuery($key, $value));
        }
        $query = new Query($boolQuery);

        $pagination = $this->finder->findPaginated($query,[
            'from' => ($page - 1) * $limit,
            'size' => $limit
        ]);

        dd($pagination->getIterator());
//        $result = new MoviePaginatedResult(
//            data: $this->finder->findPaginated($options)->getIterator(),
//            paginationData: new PaginationData(
//                total: $this->finder->findPaginated($options)->getNbResults(),
//                limit: $limit,
//                currentPage: $page,
//                lastPage: (int) ceil($this->finder->findPaginated($options)->getNbResults() / $limit)
//            )
//        );
    }
}