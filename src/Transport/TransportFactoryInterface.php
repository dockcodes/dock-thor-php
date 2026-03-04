<?php

declare(strict_types=1);

namespace Dock\Thor\Transport;

use Dock\Thor\Options;

interface TransportFactoryInterface
{
    public function create(Options $options): TransportInterface;
}
