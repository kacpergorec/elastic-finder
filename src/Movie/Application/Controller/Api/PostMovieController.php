<?php
declare (strict_types=1);

namespace App\Movie\Application\Controller\Api;

use App\Movie\Application\Controller\Api\Request\CreateMovieRequest;
use App\Movie\Application\Event\OnMovieCreationRequestEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route(path: '/api/movies', name: 'api_movie_create', methods: ['POST'])]
final class PostMovieController extends AbstractController
{
    public function __construct(
        private readonly EventDispatcherInterface $dispatcher,
    )
    {
    }

    public function __invoke(
        #[MapRequestPayload]
        CreateMovieRequest $request
    ): JsonResponse
    {
        $this->dispatcher->dispatch(new OnMovieCreationRequestEvent(
            title: $request->title,
            releaseDate: $request->releaseDate,
            rating: $request->rating,
            description: $request->description
        ));

        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}