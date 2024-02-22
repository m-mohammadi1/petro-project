<?php

namespace Modules\Client\Repository\Location;

use Modules\Client\App\Models\Location;
use Modules\Shared\Repository\memory\BaseMemoryRepository;

class LocationMemoryRepository extends BaseMemoryRepository implements LocationRepositoryInterface
{
    protected function getModel(): string
    {
        return Location::class;
    }

    public function createLocations(int $client_id, array $locations): void
    {
        foreach ($locations as $location) {
            $this->create([
                "client_id" => $client_id,
                "title" => $location["title"],
                "lat" => $location["lat"],
                "lon" => $location["lon"],
            ]);
        }
    }
}
