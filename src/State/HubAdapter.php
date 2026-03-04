<?php

declare(strict_types=1);

namespace Dock\Thor\State;

use Dock\Thor\Breadcrumb;
use Dock\Thor\ClientInterface;
use Dock\Thor\Event;
use Dock\Thor\EventHint;
use Dock\Thor\EventId;
use Dock\Thor\Integration\IntegrationInterface;
use Dock\Thor\ThorSdk;
use Dock\Thor\Severity;
use Dock\Thor\Tracing\Span;
use Dock\Thor\Tracing\Transaction;
use Dock\Thor\Tracing\TransactionContext;

final class HubAdapter implements HubInterface
{
    /**
     * @var self|null
     */
    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance(): self
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getClient(): ?ClientInterface
    {
        return ThorSdk::getCurrentHub()->getClient();
    }

    public function getLastEventId(): ?EventId
    {
        return ThorSdk::getCurrentHub()->getLastEventId();
    }

    public function pushScope(): Scope
    {
        return ThorSdk::getCurrentHub()->pushScope();
    }

    public function popScope(): bool
    {
        return ThorSdk::getCurrentHub()->popScope();
    }

    public function withScope(callable $callback): void
    {
        ThorSdk::getCurrentHub()->withScope($callback);
    }

    public function configureScope(callable $callback): void
    {
        ThorSdk::getCurrentHub()->configureScope($callback);
    }

    public function bindClient(ClientInterface $client): void
    {
        ThorSdk::getCurrentHub()->bindClient($client);
    }

    public function captureMessage(string $message, ?Severity $level = null, ?EventHint $hint = null): ?EventId
    {
        return ThorSdk::getCurrentHub()->captureMessage($message, $level, $hint);
    }

    public function captureException(\Throwable $exception, ?EventHint $hint = null): ?EventId
    {
        return ThorSdk::getCurrentHub()->captureException($exception, $hint);
    }

    public function captureEvent(Event $event, ?EventHint $hint = null): ?EventId
    {
        return ThorSdk::getCurrentHub()->captureEvent($event, $hint);
    }

    public function captureLastError(?EventHint $hint = null): ?EventId
    {
        return ThorSdk::getCurrentHub()->captureLastError($hint);
    }

    public function addBreadcrumb(Breadcrumb $breadcrumb): bool
    {
        return ThorSdk::getCurrentHub()->addBreadcrumb($breadcrumb);
    }

    public function getIntegration(string $className): ?IntegrationInterface
    {
        return ThorSdk::getCurrentHub()->getIntegration($className);
    }

    public function startTransaction(TransactionContext $context, array $customSamplingContext = []): Transaction
    {
        return ThorSdk::getCurrentHub()->startTransaction($context, $customSamplingContext);
    }

    public function getTransaction(): ?Transaction
    {
        return ThorSdk::getCurrentHub()->getTransaction();
    }

    public function getSpan(): ?Span
    {
        return ThorSdk::getCurrentHub()->getSpan();
    }

    public function setSpan(?Span $span): HubInterface
    {
        return ThorSdk::getCurrentHub()->setSpan($span);
    }

    public function __clone()
    {
        throw new \BadMethodCallException('Cloning is forbidden.');
    }

    public function __wakeup()
    {
        throw new \BadMethodCallException('Unserializing instances of this class is forbidden.');
    }
}
