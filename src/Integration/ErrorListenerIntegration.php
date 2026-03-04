<?php

declare(strict_types=1);

namespace Dock\Thor\Integration;

use Dock\Thor\ErrorHandler;
use Dock\Thor\Exception\SilencedErrorException;
use Dock\Thor\ThorSdk;

final class ErrorListenerIntegration extends AbstractErrorListenerIntegration
{
    public function setupOnce(): void
    {
        $errorHandler = ErrorHandler::registerOnceErrorHandler();
        $errorHandler->addErrorHandlerListener(static function (\ErrorException $exception): void {
            $currentHub = ThorSdk::getCurrentHub();
            $integration = $currentHub->getIntegration(self::class);
            $client = $currentHub->getClient();

            if (null === $integration || null === $client) {
                return;
            }

            if ($exception instanceof SilencedErrorException && !$client->getOptions()->shouldCaptureSilencedErrors()) {
                return;
            }

            if (!$exception instanceof SilencedErrorException && !($client->getOptions()->getErrorTypes() & $exception->getSeverity())) {
                return;
            }

            $integration->captureException($currentHub, $exception);
        });
    }
}
