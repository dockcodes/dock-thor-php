<?php

declare(strict_types=1);

namespace Dock\Thor\Tracing;

use Psr\Http\Message\RequestInterface;
use Dock\Thor\ThorSdk;
use Dock\Thor\State\HubInterface;

final class GuzzleTracingMiddleware
{
    public static function trace(?HubInterface $hub = null): \Closure
    {
        return function (callable $handler) use ($hub): \Closure {
            return function (RequestInterface $request, array $options) use ($hub, $handler) {
                $hub = $hub ?? ThorSdk::getCurrentHub();
                $span = $hub->getSpan();
                $childSpan = null;

                if (null !== $span) {
                    $spanContext = new SpanContext();
                    $spanContext->setOp('http.guzzle');
                    $spanContext->setDescription($request->getMethod() . ' ' . $request->getUri());

                    $childSpan = $span->startChild($spanContext);
                }

                $handlerPromiseCallback = static function ($responseOrException) use ($childSpan) {
                    if (null !== $childSpan) {
                        $childSpan->finish();
                    }

                    if ($responseOrException instanceof \Throwable) {
                        throw $responseOrException;
                    }

                    return $responseOrException;
                };

                return $handler($request, $options)->then($handlerPromiseCallback, $handlerPromiseCallback);
            };
        };
    }
}
