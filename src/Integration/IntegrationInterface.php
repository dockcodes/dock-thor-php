<?php

declare(strict_types=1);

namespace Dock\Thor\Integration;

interface IntegrationInterface
{
    public function setupOnce(): void;
}
