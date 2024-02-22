<?php

namespace Modules\Client\Services\OrderManager;

use Modules\Client\App\Models\Order;
use Modules\Client\Services\OrderManager\Types\NewOrderData;

interface OrderManagerServiceInterface
{
    public function createOrder(NewOrderData $data): Order;
}
