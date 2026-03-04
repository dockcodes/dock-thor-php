<?php

declare(strict_types=1);

namespace Dock\Thor\HttpClient\Authentication;

use Http\Message\Authentication as AuthenticationInterface;
use Psr\Http\Message\RequestInterface;
use Dock\Thor\Options;

final class ThorAuthentication implements AuthenticationInterface
{
    /**
     * @var Options
     */
    private $options;

    /**
     * @var string
     */
    private $sdkIdentifier;

    /**
     * @var string
     */
    private $sdkVersion;

    public function __construct(Options $options, string $sdkIdentifier, string $sdkVersion)
    {
        $this->options = $options;
        $this->sdkIdentifier = $sdkIdentifier;
        $this->sdkVersion = $sdkVersion;
    }

    public function authenticate(RequestInterface $request): RequestInterface
    {
        $authData = $this->options->getAuthData();

        if (null === $authData) {
            return $request;
        }

        return $request->withHeader('Authorization', 'Bearer ' . $authData->getPrivateKey());
    }
}
