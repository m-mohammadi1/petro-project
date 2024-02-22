<?php

namespace Modules\Client\Services\OrderManager;

use Illuminate\Contracts\Auth\Guard;
use Modules\Auth\App\Models\User;
use Modules\Client\App\Models\Order;
use Modules\Client\Enums\OrderStatus;
use Modules\Client\Repository\Order\OrderRepositoryInterface;
use Modules\Client\Services\OrderManager\Types\NewOrderData;

class OrderManagerService implements OrderManagerServiceInterface
{
    public function __construct(
        private readonly Guard                    $guard,
        private readonly OrderRepositoryInterface $orderRepository,
    )
    {
    }

    public function createOrder(NewOrderData $data): Order
    {
        $orderData = [
            "company_id" => $data->company->id,
            "client_id" => $data->client->id,
            "location_id" => $data->location->id,
            "truck_id" => $data->truck->id,
            "status" => OrderStatus::PROGRESSING,
        ];

        $this->checkAuthUserIsCompanyAdmin($data);
        $this->checkClientIsForTheCompany($data);
        $this->checkLocationIsForTheClient($data);
        $this->checkTruckIsForTheCompany($data);

        $order = $this->orderRepository->create($orderData);

        return $order;
    }

    /**
     * @param NewOrderData $data
     * @return void
     * @throws \Exception
     */
    public function checkAuthUserIsCompanyAdmin(NewOrderData $data): void
    {
        /** @var User $user */
        $user = $this->guard->user();
        if ($user->id !== $data->company->admin_id) {
            throw new \Exception("only company admin can create order.");
        }
    }

    /**
     * @param NewOrderData $data
     * @return void
     * @throws \Exception
     */
    public function checkClientIsForTheCompany(NewOrderData $data): void
    {
        if ($data->client->company_id !== $data->company->id) {
            throw new \Exception("only only could be created for company clients");
        }
    }

    /**
     * @param NewOrderData $data
     * @return void
     * @throws \Exception
     */
    public function checkLocationIsForTheClient(NewOrderData $data): void
    {
        if ($data->client->id !== $data->location->id) {
            throw new \Exception("provided locations is not for the client.");
        }
    }

    /**
     * @param NewOrderData $data
     * @return void
     * @throws \Exception
     */
    public function checkTruckIsForTheCompany(NewOrderData $data): void
    {
        if ($data->truck->company_id !== $data->company->id) {
            throw new \Exception("provided truck is not for the company.");
        }
    }
}
