<?php

namespace Modules\Client\tests\Unit;

use Illuminate\Contracts\Auth\Guard;
use Modules\Auth\App\Models\User;
use Modules\Client\App\Models\Client;
use Modules\Client\App\Models\Location;
use Modules\Client\Enums\OrderStatus;
use Modules\Client\Repository\Client\ClientMemoryRepository;
use Modules\Client\Repository\Client\ClientRepositoryInterface;
use Modules\Client\Repository\Location\LocationMemoryRepository;
use Modules\Client\Repository\Location\LocationRepositoryInterface;
use Modules\Client\Repository\Order\OrderMemoryRepository;
use Modules\Client\Repository\Order\OrderRepositoryInterface;
use Modules\Client\Services\ClientManager\ClientManagerService;
use Modules\Client\Services\ClientManager\ClientManagerServiceInterface;
use Modules\Client\Services\ClientManager\Types\ClientCreateData;
use Modules\Client\Services\ClientManager\Types\LocationData;
use Modules\Client\Services\OrderManager\OrderManagerService;
use Modules\Client\Services\OrderManager\OrderManagerServiceInterface;
use Modules\Client\Services\OrderManager\Types\NewOrderData;
use Modules\Company\App\Models\Company;
use Modules\Company\App\Models\Truck;
use Modules\Company\Repository\Company\CompanyMemoryRepository;
use Modules\Company\Repository\Company\CompanyRepositoryInterface;
use Modules\Company\Repository\Truck\TruckMemoryRepository;
use Modules\Company\Repository\Truck\TruckRepositoryInterface;
use Tests\TestCase;

class OrderManagerTest extends TestCase
{
    public function test_admin_can_create_order_with_valid_data(): void
    {
        // we need an admin user
        // we need a company, a truck, and a client
        $admin = User::factory()->make(['id' => 1]);
        [$orderRepo, $companyRepo, $clientRepo, $locRepo, $truckRepo] = $this->mockDependencies($admin);
        $company = $this->createCompany($companyRepo, $admin);
        $truck = $this->createTruck($truckRepo, $company->id);
        $client = $this->createClient($clientRepo, $company->id);
        $location = $this->createLocation($locRepo, $client->id);

        // create client with locations
        /** @var OrderManagerServiceInterface $service */
        $service = resolve(OrderManagerService::class);

        $data = new NewOrderData(
            $company->id, $client->id, $location->id, $truck->id
        );

        $order = $service->createOrder($data);
        $this->assertNotNull($order);

        $createdOrder = $orderRepo->find($order->id);
        $this->assertEquals($createdOrder->status->value, OrderStatus::PROGRESSING->value);
        $this->assertEquals($createdOrder->company_id, $company->id);
        $this->assertEquals($createdOrder->truck_id, $truck->id);
        $this->assertEquals($createdOrder->location_id, $location->id);
    }

    public function test_none_admin_cannot_create_order(): void
    {
        $admin = User::factory()->make(['id' => 1]);
        $noneAdmin = User::factory()->make(['id' => 2]);
        [$orderRepo, $companyRepo, $clientRepo, $locRepo, $truckRepo] = $this->mockDependencies($noneAdmin);
        $company = $this->createCompany($companyRepo, $admin);
        $truck = $this->createTruck($truckRepo, $company->id);
        $client = $this->createClient($clientRepo, $company->id);
        $location = $this->createLocation($locRepo, $client->id);

        $this->expectException(\Exception::class);

        /** @var OrderManagerServiceInterface $service */
        $service = resolve(OrderManagerService::class);

        $data = new NewOrderData(
            $company->id, $client->id, $location->id, $truck->id
        );

        $order = $service->createOrder($data);
    }

    public function test_admin_cannot_create_order_with_invalid_client(): void
    {
        $admin = User::factory()->make(['id' => 1]);
        [$orderRepo, $companyRepo, $clientRepo, $locRepo, $truckRepo] = $this->mockDependencies($admin);
        $company = $this->createCompany($companyRepo, $admin);
        $truck = $this->createTruck($truckRepo, $company->id);
        $client = $this->createClient($clientRepo, 2);
        $location = $this->createLocation($locRepo, $client->id);


        $this->expectException(\Exception::class);

        /** @var OrderManagerServiceInterface $service */
        $service = resolve(OrderManagerService::class);

        $data = new NewOrderData(
            $company->id, $client->id, $location->id, $truck->id
        );

        $order = $service->createOrder($data);
    }

    public function test_admin_cannot_create_order_with_invalid_location(): void
    {
        $admin = User::factory()->make(['id' => 1]);
        [$orderRepo, $companyRepo, $clientRepo, $locRepo, $truckRepo] = $this->mockDependencies($admin);
        $company = $this->createCompany($companyRepo, $admin);
        $truck = $this->createTruck($truckRepo, $company->id);
        $client = $this->createClient($clientRepo, $company->id);
        $location = $this->createLocation($locRepo, 2);


        /** @var OrderManagerServiceInterface $service */
        $service = resolve(OrderManagerService::class);

        $data = new NewOrderData(
            $company->id, $client->id, $location->id, $truck->id
        );

        $this->expectException(\Exception::class);

        $order = $service->createOrder($data);
    }

    public function test_admin_cannot_create_order_with_invalid_truck(): void
    {
        $admin = User::factory()->make(['id' => 1]);
        [$orderRepo, $companyRepo, $clientRepo, $locRepo, $truckRepo] = $this->mockDependencies($admin);
        $company = $this->createCompany($companyRepo, $admin);
        $truck = $this->createTruck($truckRepo, 2);
        $client = $this->createClient($clientRepo, $company->id);
        $location = $this->createLocation($locRepo, 2);

        $this->expectException(\Exception::class);

        /** @var OrderManagerServiceInterface $service */
        $service = resolve(OrderManagerService::class);

        $data = new NewOrderData(
            $company->id, $client->id, $location->id, $truck->id
        );

        $order = $service->createOrder($data);
    }


    private function mockOrderRepo(): OrderMemoryRepository
    {
        $memory = new OrderMemoryRepository();
        $this->app->bind(OrderRepositoryInterface::class, function () use ($memory) {
            return $memory;
        });
        return $memory;
    }

    public function mockDependencies(User $admin): array
    {
        $orderRepo = $this->mockRepo(OrderRepositoryInterface::class, OrderMemoryRepository::class);
        $companyRepo = $this->mockRepo(CompanyRepositoryInterface::class, CompanyMemoryRepository::class);
        $clientRepo = $this->mockRepo(ClientRepositoryInterface::class, ClientMemoryRepository::class);
        $locRepo = $this->mockRepo(LocationRepositoryInterface::class, LocationMemoryRepository::class);
        $truckRepo = $this->mockRepo(TruckRepositoryInterface::class, TruckMemoryRepository::class);

        $this->mock(Guard::class)
            ->shouldReceive('user')
            ->andReturn($admin);

        return [$orderRepo, $companyRepo, $clientRepo, $locRepo, $truckRepo];
    }


    private function createLocation(LocationRepositoryInterface $locationRepository, int $client_id): Location
    {
        return $locationRepository->create(Location::factory()->make([
            "client_id" => $client_id
        ])->toArray());
    }

    private function createClient(ClientRepositoryInterface $clientRepository, int $company_id): Client
    {
        return $clientRepository->create(Client::factory()->make([
            'company_id' => $company_id,
        ])->toArray());
    }

    private function createTruck(TruckRepositoryInterface $truckRepository, int $company_id): Truck
    {
        return $truckRepository->create(Truck::factory()->make([
            'company_id' => $company_id
        ])->toArray());
    }


    private function createCompany(CompanyRepositoryInterface $companyRepository, User $admin): Company
    {
        return $companyRepository->create(Company::factory()->make([
            "admin_id" => $admin->id
        ])->toArray());
    }
}
