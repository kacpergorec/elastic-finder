<?php
declare (strict_types=1);

namespace App\Movie\Application\Service;

use App\Movie\Application\Model\CreateMovieCommand;
use App\Movie\Domain\Entity\Movie;
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
        $movie = new Movie(
            title: $command->title,
            rating: $command->rating,
            releaseDate: \DateTime::createFromImmutable($command->releaseDate),
        );
        $movie->setDescription($command->description);

        $this->movieRepository->save($movie);

        $movie->recordDomainEvent(new MovieCreatedEvent($movie->getId()));

        foreach ($movie->getDomainEvents() as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }
}