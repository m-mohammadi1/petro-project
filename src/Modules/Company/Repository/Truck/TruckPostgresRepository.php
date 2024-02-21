<?php

namespace Modules\Company\Repository\Truck;

use Modules\Company\App\Models\Truck;
use Modules\Shared\Repository\postgres\BasePostgresRepository;

class TruckPostgresRepository extends BasePostgresRepository implements TruckRepositoryInterface
{
    protected function getModel(): string
    {
        return Truck::class;
    }
}
