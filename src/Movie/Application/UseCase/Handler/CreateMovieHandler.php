<?php
declare (strict_types=1);

namespace App\Movie\Application\UseCase\Handler;

use App\Movie\Application\UseCase\Command\CreateMovieCommand;
use App\Movie\Domain\Entity\Movie;
use App\Movie\Domain\Entity\MovieId;
use App\Movie\Domain\Event\MovieCreatedEvent;
use App\Movie\Domain\Repository\MovieRepositoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateMovieHandler
{
    public function __construct(
        public MovieRepositoryInterface $movieRepository,
        public EventDispatcherInterface $eventDispatcher
    )
    {
    }

    public function __invoke(CreateMovieCommand $command): void
    {
        $movie = Movie::create(
            MovieId::new(),
            $command->title,
            $command->rating,
            $command->releaseDate
        );
        $movie->setDescription($command->description);

        $this->movieRepository->save($movie);

        foreach ($movie->pullEvents() as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }
}