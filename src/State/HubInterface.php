<?php

declare(strict_types=1);

namespace Dock\Thor\State;

use Dock\Thor\Breadcrumb;
use Dock\Thor\ClientInterface;
use Dock\Thor\Event;
use Dock\Thor\EventHint;
use Dock\Thor\EventId;
use Dock\Thor\Integration\IntegrationInterface;
use Dock\Thor\Severity;
use Dock\Thor\Tracing\SamplingContext;
use Dock\Thor\Tracing\Span;
use Dock\Thor\Tracing\Transaction;
use Dock\Thor\Tracing\TransactionContext;

interface HubInterface
{
    public function getClient(): ?ClientInterface;
    
    public function getLastEventId(): ?EventId;

    public function pushScope(): Scope;

    public function popScope(): bool;

    public function withScope(callable $callback): void;
    
    public function configureScope(callable $callback): void;

    public function bindClient(ClientInterface $client): void;

    public function captureMessage(string $message, ?Severity $level = null/*, ?EventHint $hint = null*/): ?EventId;

    public function captureException(\Throwable $exception/*, ?EventHint $hint = null*/): ?EventId;

    public function captureEvent(Event $event, ?EventHint $hint = null): ?EventId;

    public function captureLastError(/*?EventHint $hint = null*/): ?EventId;

    public function addBreadcrumb(Breadcrumb $breadcrumb): bool;

    public function getIntegration(string $className): ?IntegrationInterface;

    public function startTransaction(TransactionContext $context/*, array $customSamplingContext = []*/): Transaction;

    public function getTransaction(): ?Transaction;

    public function getSpan(): ?Span;

    public function setSpan(?Span $span): HubInterface;
}
