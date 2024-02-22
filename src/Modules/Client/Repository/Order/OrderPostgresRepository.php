<?php

namespace Modules\Client\Repository\Order;

use Modules\Client\App\Models\Order;
use Modules\Shared\Repository\postgres\BasePostgresRepository;

class OrderPostgresRepository extends BasePostgresRepository implements OrderRepositoryInterface
{
    protected function getModel(): string
    {
        return Order::class;
    }
}
