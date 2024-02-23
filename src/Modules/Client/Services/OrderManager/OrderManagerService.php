<?php

namespace Modules\Client\Services\OrderManager;

use Illuminate\Contracts\Auth\Guard;
use Modules\Auth\App\Models\User;
use Modules\Client\App\Models\Client;
use Modules\Client\App\Models\Location;
use Modules\Client\App\Models\Order;
use Modules\Client\Enums\OrderStatus;
use Modules\Client\Repository\Client\ClientRepositoryInterface;
use Modules\Client\Repository\Location\LocationRepositoryInterface;
use Modules\Client\Repository\Order\OrderRepositoryInterface;
use Modules\Client\Services\OrderManager\Types\NewOrderData;
use Modules\Company\App\Models\Company;
use Modules\Company\App\Models\Truck;
use Modules\Company\Repository\Company\CompanyRepositoryInterface;
use Modules\Company\Repository\Truck\TruckRepositoryInterface;

class OrderManagerService implements OrderManagerServiceInterface
{
    public function __construct(
        private readonly Guard                       $guard,
        private readonly OrderRepositoryInterface    $orderRepository,
        private readonly CompanyRepositoryInterface  $companyRepository,
        private readonly ClientRepositoryInterface   $clientRepository,
        private readonly LocationRepositoryInterface $locationRepository,
        private readonly TruckRepositoryInterface    $truckRepository,
    )
    {
    }

    public function createOrder(NewOrderData $data): Order
    {
        $company = $this->companyRepository->findOrFail($data->company_id);
        $client = $this->clientRepository->findOrFail($data->client_id);
        $location = $this->locationRepository->findOrFail($data->location_id);
        $truck = $this->truckRepository->findOrFail($data->truck_id);

        $orderData = [
            "company_id" => $company->id,
            "client_id" => $client->id,
            "location_id" => $location->id,
            "truck_id" => $truck->id,
            "status" => OrderStatus::PROGRESSING,
        ];

        $this->checkAuthUserIsCompanyAdmin($company);
        $this->checkClientIsForTheCompany($client, $company);
        $this->checkLocationIsForTheClient($client, $location);
        $this->checkTruckIsForTheCompany($truck, $company);

        return $this->orderRepository->create($orderData);
    }


    public function checkAuthUserIsCompanyAdmin(Company $company): void
    {
        /** @var User $user */
        $user = $this->guard->user();
        if ($user->id !== $company->admin_id) {
            throw new \Exception("only company admin can create order.");
        }
    }


    public function checkClientIsForTheCompany(Client $client, Company $company): void
    {
        if ($client->company_id !== $company->id) {
            throw new \Exception("only only could be created for company clients");
        }
    }


    public function checkLocationIsForTheClient(Client $client, Location $location): void
    {
        if ($client->id !== $location->client_id) {
            throw new \Exception("provided locations is not for the client.");
        }
    }


    public function checkTruckIsForTheCompany(Truck $truck, Company $company): void
    {
        if ($truck->company_id !== $company->id) {
            throw new \Exception("provided truck is not for the company.");
        }
    }
}
