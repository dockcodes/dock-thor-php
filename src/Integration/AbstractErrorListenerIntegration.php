<?php

declare(strict_types=1);

namespace Dock\Thor\Integration;

use Dock\Thor\Event;
use Dock\Thor\ExceptionMechanism;
use Dock\Thor\State\HubInterface;
use Dock\Thor\State\Scope;

abstract class AbstractErrorListenerIntegration implements IntegrationInterface
{
    protected function captureException(HubInterface $hub, \Throwable $exception): void
    {
        $hub->withScope(function (Scope $scope) use ($hub, $exception): void {
            $scope->addEventProcessor(\Closure::fromCallable([$this, 'addExceptionMechanismToEvent']));

            $hub->captureException($exception);
        });
    }

    protected function addExceptionMechanismToEvent(Event $event): Event
    {
        $exceptions = $event->getExceptions();

        foreach ($exceptions as $exception) {
            $exception->setMechanism(new ExceptionMechanism(ExceptionMechanism::TYPE_GENERIC, false));
        }

        return $event;
    }
}
