<?php

namespace Modules\Company\Services\TruckManager\Types;

class CreateTruckData
{
    public function __construct(
        public readonly int $company_id,
        public readonly string $driver_name,
    )
    {
    }
}
