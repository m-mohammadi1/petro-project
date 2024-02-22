<?php

namespace Modules\Client\Services\OrderManager\Types;

use Modules\Client\App\Models\Client;
use Modules\Client\App\Models\Location;
use Modules\Company\App\Models\Company;
use Modules\Company\App\Models\Truck;

class NewOrderData
{
    public function __construct(
        public readonly Company  $company,
        public readonly Client   $client,
        public readonly Location $location,
        public readonly Truck    $truck,
    )
    {
    }
}
