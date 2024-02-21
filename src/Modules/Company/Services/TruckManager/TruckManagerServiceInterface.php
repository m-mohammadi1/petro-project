<?php

namespace Modules\Company\Services\TruckManager;

use Modules\Company\App\Models\Truck;
use Modules\Company\Services\TruckManager\Types\CreateTruckData;

interface TruckManagerServiceInterface
{
    public function addTruckToCompany(CreateTruckData $data): Truck;

    public function deleteTruck(int $id): void;
}
