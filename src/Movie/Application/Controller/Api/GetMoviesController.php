<?php
declare (strict_types=1);

namespace App\Movie\Application\Controller\Api;

use App\Movie\Application\Model\FindMoviesQuery;
use App\Shared\Controller\AbstractApiController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;


#[AsController]
#[Route(path: '/api/movies', name: 'api_movie', methods: ['GET'])]
final class GetMoviesController extends AbstractController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(): Response
    {
       $movies = $this->handle(new FindMoviesQuery());

       return $this->json($movies);
    }
}