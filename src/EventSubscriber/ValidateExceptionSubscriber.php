<?php

namespace App\EventSubscriber;

use App\Exception\ValidationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ValidateExceptionSubscriber implements EventSubscriberInterface
{
    public function onExceptionEvent(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();

        if($e instanceof ValidationException){
            $event->setResponse(new JsonResponse([
                'errors' => $e->getErrors()
            ], 422));
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ExceptionEvent::class => 'onExceptionEvent',
        ];
    }
}
