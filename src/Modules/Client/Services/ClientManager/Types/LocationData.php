<?php

namespace Modules\Client\Services\ClientManager\Types;

class LocationData
{
    public function __construct(
        public readonly string $name,
        public readonly float  $lat,
        public readonly float  $lon,
    )
    {
    }
}
