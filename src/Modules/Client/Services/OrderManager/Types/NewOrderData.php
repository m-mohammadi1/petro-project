<?php

namespace Modules\Client\Services\OrderManager\Types;


class NewOrderData
{
    public function __construct(
        public readonly int  $company_id,
        public readonly int   $client_id,
        public readonly int $location_id,
        public readonly int    $truck_id,
    )
    {
    }
}
