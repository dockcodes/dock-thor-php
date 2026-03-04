<?php

declare(strict_types=1);

namespace Dock\Thor\Transport;

use Dock\Thor\HttpClient\HttpClientFactoryInterface;
use Dock\Thor\Options;
use Dock\Thor\Serializer\PayloadSerializer;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerInterface;

final class DefaultTransportFactory implements TransportFactoryInterface
{
    /**
     * @var StreamFactoryInterface
     */
    private $streamFactory;

    /**
     * @var RequestFactoryInterface
     */
    private $requestFactory;

    /**
     * @var HttpClientFactoryInterface
     */
    private $httpClientFactory;

    /**
     * @var LoggerInterface|null
     */
    private $logger;

    public function __construct(StreamFactoryInterface $streamFactory, RequestFactoryInterface $requestFactory, HttpClientFactoryInterface $httpClientFactory, ?LoggerInterface $logger = null)
    {
        $this->streamFactory = $streamFactory;
        $this->requestFactory = $requestFactory;
        $this->httpClientFactory = $httpClientFactory;
        $this->logger = $logger;
    }

    public function create(Options $options): TransportInterface
    {
        if (null === $options->getAuthData()) {
            return new NullTransport();
        }

        return new HttpTransport(
            $options,
            $this->httpClientFactory->create($options),
            $this->streamFactory,
            $this->requestFactory,
            new PayloadSerializer(),
            $this->logger
        );
    }
}
