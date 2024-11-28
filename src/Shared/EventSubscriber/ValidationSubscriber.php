<?php
declare (strict_types=1);

namespace App\Shared\EventSubscriber;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class ValidationSubscriber implements EventSubscriberInterface
{
    private const SUBSCRIBED_FIREWALL = 'main';

    public function __construct(
        private readonly Security $security,
    )
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ExceptionEvent::class => 'onException',
        ];
    }

    public function onException(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();

        if (!$throwable instanceof HttpExceptionInterface) {
            return;
        }

        $firewall = $this->security->getFirewallConfig($event->getRequest())?->getName();

        $validationThrowable = $throwable->getPrevious();

        if (
            self::SUBSCRIBED_FIREWALL !== $firewall ||
            !$validationThrowable instanceof ValidationFailedException
        ) {
            return;
        }

        foreach ($validationThrowable->getViolations() as $violation) {
            $errors[$violation->getPropertyPath()][] = $violation->getMessage();
        }

        $response = new JsonResponse(
            data: [
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => $errors ?? [],
            ],
            status: Response::HTTP_UNPROCESSABLE_ENTITY,
        );

        $event->setResponse($response);
    }
}