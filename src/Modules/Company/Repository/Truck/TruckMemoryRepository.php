<?php

namespace Modules\Company\Repository\Truck;

use Modules\Company\App\Models\Truck;
use Modules\Shared\Repository\memory\BaseMemoryRepository;

class TruckMemoryRepository extends BaseMemoryRepository implements TruckRepositoryInterface
{
    protected function getModel(): string
    {
        return Truck::class;
    }
}
