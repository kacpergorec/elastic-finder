<?php
declare (strict_types=1);

namespace App\Movie\Application\Controller\Api;

use App\Movie\Application\Controller\Api\Request\GetMoviesRequest;
use App\Movie\Application\Controller\Api\Response\MovieListResponse;
use App\Movie\Application\UseCase\Query\FindMoviesQuery;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;


#[AsController]
#[Route(path: '/api/movies', name: 'api_movie_list', methods: ['GET'])]
final class GetMoviesController extends AbstractController
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $messageBus,
    )
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(
        #[MapQueryString]
        ?GetMoviesRequest $request = new GetMoviesRequest(),
    ): Response
    {
        /** @var PaginationInterface $movies */
        $movies = $this->handle(
            FindMoviesQuery::fromRequest($request)
        );

        return $this->json(
            MovieListResponse::fromPagination($movies)
        );
    }
}