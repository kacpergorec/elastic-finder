<?php
declare (strict_types=1);

namespace App\Movie\Application\Service;

use App\Movie\Application\Model\FindMoviesQuery;
use App\Movie\Domain\Entity\Movie;
use App\Movie\Domain\Repository\MovieQueryRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class MovieProviderHandler
{
    public function __construct(
       public MovieQueryRepositoryInterface $movieQueryRepository
    )
    {
    }

    /**
     * @return Movie[]
     */
    public function __invoke(FindMoviesQuery $findMoviesQuery): array
    {
        return $this->movieQueryRepository->findAll();
    }
}