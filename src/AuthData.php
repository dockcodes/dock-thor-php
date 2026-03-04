<?php

declare(strict_types=1);

namespace Dock\Thor;

final class AuthData implements \Stringable
{
    /**
     * @var string
     */
    private $scheme;

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $privateKey;

    private function __construct(string $token, string $privateKey)
    {
        $this->scheme = 'https';
        $this->path = '/api/v1';
        $this->host = 'thor.dock.codes';
        $this->token = $token;
        $this->privateKey = $privateKey;
    }

    public static function create(string $token, string $privateKey): self
    {
        return new self($token, $privateKey);
    }

    public function getScheme(): string
    {
        return $this->scheme;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPrivateKey(): string
    {
        return $this->privateKey;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getProjectApiEndpointUrl(): string
    {
        return $this->getBaseEndpointUrl() . '/project/';
    }

    public function getTransactionApiEndpointUrl(): string
    {
        return $this->getBaseEndpointUrl() . '/transaction/';
    }

    public function __toString(): string
    {
        return $this->getBaseEndpointUrl();
    }

    private function getBaseEndpointUrl(): string
    {
        $url = $this->scheme . '://' . $this->host;

        if (null !== $this->path) {
            $url .= $this->path;
        }

        $url .= '/' . $this->token;

        return $url;
    }
}
