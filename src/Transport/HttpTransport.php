<?php

declare(strict_types=1);

namespace Dock\Thor\Transport;

use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Promise\RejectedPromise;
use Http\Client\HttpAsyncClient as HttpAsyncClientInterface;
use Dock\Thor\Event;
use Dock\Thor\EventType;
use Dock\Thor\Options;
use Dock\Thor\Response;
use Dock\Thor\ResponseStatus;
use Dock\Thor\Serializer\PayloadSerializerInterface;
use Dock\Thor\Util\JSON;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

final class HttpTransport implements TransportInterface
{
    /**
     * @var Options
     */
    private $options;

    /**
     * @var HttpAsyncClientInterface
     */
    private $httpClient;

    /**
     * @var StreamFactoryInterface
     */
    private $streamFactory;

    /**
     * @var RequestFactoryInterface
     */
    private $requestFactory;

    /**
     * @var PayloadSerializerInterface
     */
    private $payloadSerializer;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        Options                    $options,
        HttpAsyncClientInterface   $httpClient,
        StreamFactoryInterface     $streamFactory,
        RequestFactoryInterface    $requestFactory,
        PayloadSerializerInterface $payloadSerializer,
        ?LoggerInterface           $logger = null
    )
    {
        $this->options = $options;
        $this->httpClient = $httpClient;
        $this->streamFactory = $streamFactory;
        $this->requestFactory = $requestFactory;
        $this->payloadSerializer = $payloadSerializer;
        $this->logger = $logger ?? new NullLogger();
    }

    public function send(Event $event): PromiseInterface
    {
        $authData = $this->options->getAuthData();
        $content = $this->payloadSerializer->serialize($event);
        $request = null;
        if (!empty($authData->getToken()) && !empty($authData->getPrivateKey())) {
            if (EventType::transaction() === $event->getType()) {
                $request = $this->requestFactory->createRequest('POST', $authData->getTransactionApiEndpointUrl())
                    ->withHeader('Content-Type', 'application/json')
                    ->withHeader('Authorization', 'Bearer '.$authData->getPrivateKey())
                    ->withBody($this->streamFactory->createStream($content));
            } else {
                $request = $this->requestFactory->createRequest('POST', $authData->getProjectApiEndpointUrl())
                    ->withHeader('Content-Type', 'application/json')
                    ->withHeader('Authorization', 'Bearer '.$authData->getPrivateKey())
                    ->withBody($this->streamFactory->createStream($content));
            }
        }
        try {
            /** @var ResponseInterface $response */
            $response = $this->httpClient->sendAsyncRequest($request)->wait();
        } catch (\Throwable $exception) {
            $this->logger->error(
                sprintf('Failed to send the event to Thor. Reason: "%s".', $exception->getMessage()),
                ['exception' => $exception, 'event' => $event]
            );

            return new RejectedPromise(new Response(ResponseStatus::failed(), $event));
        }

        $sendResponse = new Response(ResponseStatus::createFromHttpStatusCode($response->getStatusCode()), $event);

        if (ResponseStatus::success() === $sendResponse->getStatus()) {
            return new FulfilledPromise($sendResponse);
        }

        return new RejectedPromise($sendResponse);
    }

    public function close(?int $timeout = null): PromiseInterface
    {
        return new FulfilledPromise(true);
    }
}
