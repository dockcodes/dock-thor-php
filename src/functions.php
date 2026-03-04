<?php

declare(strict_types=1);

namespace Dock\Thor;

use Dock\Thor\Tracing\Transaction;
use Dock\Thor\Tracing\TransactionContext;

function init(array $options = []): void
{
    $client = ClientBuilder::create($options)->getClient();
    ThorSdk::init()->bindClient($client);
}

function captureMessage(string $message, ?Severity $level = null, ?EventHint $hint = null): ?EventId
{
    return ThorSdk::getCurrentHub()->captureMessage($message, $level, $hint);
}

function captureException(\Throwable $exception, ?EventHint $hint = null): ?EventId
{
    return ThorSdk::getCurrentHub()->captureException($exception, $hint);
}

function captureEvent(Event $event, ?EventHint $hint = null): ?EventId
{
    return ThorSdk::getCurrentHub()->captureEvent($event, $hint);
}

function captureLastError(?EventHint $hint = null): ?EventId
{
    return ThorSdk::getCurrentHub()->captureLastError($hint);
}

function addBreadcrumb(Breadcrumb $breadcrumb): void
{
    ThorSdk::getCurrentHub()->addBreadcrumb($breadcrumb);
}

function configureScope(callable $callback): void
{
    ThorSdk::getCurrentHub()->configureScope($callback);
}

function withScope(callable $callback): void
{
    ThorSdk::getCurrentHub()->withScope($callback);
}

function startTransaction(TransactionContext $context, array $customSamplingContext = []): Transaction
{
    return ThorSdk::getCurrentHub()->startTransaction($context, $customSamplingContext);
}
