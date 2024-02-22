<?php

namespace Modules\Client\Repository\Location;

use Modules\Client\App\Models\Location;
use Modules\Shared\Repository\postgres\BasePostgresRepository;

class LocationsPostgresRepository extends BasePostgresRepository implements LocationRepositoryInterface
{

    protected function getModel(): string
    {
        return Location::class;
    }

    public function createLocations(int $client_id, array $locations): void
    {
        $holder = [];

        foreach ($locations as $location) {
            $holder[] = [
                "client_id" => $client_id,
                "title" => $location['title'],
                "lat" => $location['lat'],
                "lon" => $location['lon'],
            ];
        }

        $result = $this->getQuery()->insert($holder);

        if (!$result) {
            // logger here
            throw new \Exception("cannot create locations for client.");
        }
    }
}
