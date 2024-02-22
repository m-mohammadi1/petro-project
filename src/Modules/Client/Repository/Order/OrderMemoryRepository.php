<?php

namespace Modules\Client\Repository\Order;

use Modules\Client\App\Models\Order;
use Modules\Shared\Repository\memory\BaseMemoryRepository;

class OrderMemoryRepository extends BaseMemoryRepository implements OrderRepositoryInterface
{
    protected function getModel(): string
    {
        return Order::class;
    }
}
