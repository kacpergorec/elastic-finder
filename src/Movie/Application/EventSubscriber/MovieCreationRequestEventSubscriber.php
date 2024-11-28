<?php
declare (strict_types=1);

namespace App\Movie\Application\EventSubscriber;

use App\Movie\Application\Event\OnMovieCreationRequestEvent;
use App\Movie\Application\Model\CreateMovieCommand;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class MovieCreationRequestEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
       private MessageBusInterface $dispatcher,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            OnMovieCreationRequestEvent::class => 'createMovie',
        ];
    }

    public function createMovie(OnMovieCreationRequestEvent $event): void
    {
        // ... Check if user is valid
        // ... Dispatch UserVerified Event

        $this->dispatcher->dispatch(new CreateMovieCommand(
            title: $event->title,
            releaseDate: $event->releaseDate,
            rating: $event->rating,
            description: $event->description
        ));
    }
}