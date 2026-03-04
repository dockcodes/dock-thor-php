<?php

declare(strict_types=1);

namespace Dock\Thor\Integration;

use Dock\Thor\ErrorHandler;
use Dock\Thor\ThorSdk;

final class ExceptionListenerIntegration extends AbstractErrorListenerIntegration
{
    public function setupOnce(): void
    {
        $errorHandler = ErrorHandler::registerOnceExceptionHandler();
        $errorHandler->addExceptionHandlerListener(static function (\Throwable $exception): void {
            $currentHub = ThorSdk::getCurrentHub();
            $integration = $currentHub->getIntegration(self::class);

            if (null === $integration) {
                return;
            }

            $integration->captureException($currentHub, $exception);
        });
    }
}
