<?php

declare(strict_types=1);

namespace Dock\Thor\Serializer;

interface RepresentationSerializerInterface
{
    public function representationSerialize($value);
}
