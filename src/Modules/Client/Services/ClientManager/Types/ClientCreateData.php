<?php

namespace Modules\Client\Services\ClientManager\Types;

use Modules\Company\App\Models\Company;

class ClientCreateData
{
    /**
     * @param array<LocationData> $locations
     */
    public function __construct(
        public readonly Company $company,
        public readonly string     $name,
        public readonly array   $locations,
    )
    {
    }

    public function locationsToArray(): array
    {
        $holder = [];

        foreach ($this->locations as $location) {
            $holder[] = [
                "title" => $location->name,
                "lat" => $location->lat,
                "lon" => $location->lon,
            ];
        }

        return $holder;
    }
}
