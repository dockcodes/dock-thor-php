<?php

declare(strict_types=1);

namespace Dock\Thor\HttpClient;

use Http\Client\HttpAsyncClient as HttpAsyncClientInterface;
use Dock\Thor\Options;

interface HttpClientFactoryInterface
{
    public function create(Options $options): HttpAsyncClientInterface;
}
