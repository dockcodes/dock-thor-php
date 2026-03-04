<?php

declare(strict_types=1);

namespace Dock\Thor\Integration;

use Dock\Thor\Event;
use Dock\Thor\EventHint;
use Dock\Thor\ThorSdk;
use Dock\Thor\State\Scope;

final class TransactionIntegration implements IntegrationInterface
{
    public function setupOnce(): void
    {
        Scope::addGlobalEventProcessor(static function (Event $event, EventHint $hint): Event {
            $integration = ThorSdk::getCurrentHub()->getIntegration(self::class);

            if (null === $integration) {
                return $event;
            }

            if (null !== $event->getTransaction()) {
                return $event;
            }

            if (isset($hint->extra['transaction']) && \is_string($hint->extra['transaction'])) {
                $event->setTransaction($hint->extra['transaction']);
            } elseif (isset($_SERVER['PATH_INFO'])) {
                $event->setTransaction($_SERVER['PATH_INFO']);
            }

            return $event;
        });
    }
}
