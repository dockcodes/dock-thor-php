<?php

declare(strict_types=1);

namespace Dock\Thor\Serializer;

interface SerializableInterface
{
    public function serialize(): ?array;
}
