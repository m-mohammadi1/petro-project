<?php

namespace Modules\Client\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Client\App\Http\Requests\CreateOrderRequest;
use Modules\Client\App\resources\OrderResource;
use Modules\Client\Services\OrderManager\OrderManagerServiceInterface;
use Modules\Client\Services\OrderManager\Types\NewOrderData;

class CreateOrderController extends Controller
{
    public function __construct(
        private readonly OrderManagerServiceInterface $orderManagerService,
    )
    {
    }


    /**
     * creates an order for client as a delivery service.
     *
     * @param CreateOrderRequest $request
     * @return OrderResource
     */
    public function __invoke(CreateOrderRequest $request): OrderResource
    {
        $data = new NewOrderData(...$request->validated());

        $order = $this->orderManagerService->createOrder($data);

        return OrderResource::make($order);
    }
}
