<?php

declare(strict_types=1);

namespace Dock\Thor\Integration;

use Dock\Thor\ErrorHandler;
use Dock\Thor\Exception\FatalErrorException;
use Dock\Thor\ThorSdk;

final class FatalErrorListenerIntegration extends AbstractErrorListenerIntegration
{
    public function setupOnce(): void
    {
        $errorHandler = ErrorHandler::registerOnceFatalErrorHandler();
        $errorHandler->addFatalErrorHandlerListener(static function (FatalErrorException $exception): void {
            $currentHub = ThorSdk::getCurrentHub();
            $integration = $currentHub->getIntegration(self::class);
            $client = $currentHub->getClient();

            if (null === $integration || null === $client) {
                return;
            }

            if (!($client->getOptions()->getErrorTypes() & $exception->getSeverity())) {
                return;
            }

            $integration->captureException($currentHub, $exception);
        });
    }
}
