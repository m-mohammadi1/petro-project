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
use Tests\TestCase;

class OrderManagerTest extends TestCase
{
    public function test_admin_can_create_order_with_valid_data(): void
    {
        // we need an admin user
        // we need a company, a truck, and a client
        $admin = User::factory()->make(['id' => 1]);
        $company = $this->createCompany($admin);
        $truck = $this->createTruck($company->id);
        $client = $this->createClient($company->id);
        $location = $this->createLocation($client->id);

        [$orderRepo] = $this->mockDependencies($admin);


        // create client with locations
        /** @var OrderManagerServiceInterface $service */
        $service = resolve(OrderManagerService::class);

        $data = new NewOrderData(
            $company, $client, $location, $truck
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
        $company = $this->createCompany($admin);
        $truck = $this->createTruck($company->id);
        $client = $this->createClient($company->id);
        $location = $this->createLocation($client->id);

        [$orderRepo] = $this->mockDependencies($noneAdmin);


        $this->expectException(\Exception::class);

        /** @var OrderManagerServiceInterface $service */
        $service = resolve(OrderManagerService::class);

        $data = new NewOrderData(
            $company, $client, $location, $truck
        );

        $order = $service->createOrder($data);
    }

    public function test_admin_cannot_create_order_with_invalid_client(): void
    {
        $admin = User::factory()->make(['id' => 1]);
        $noneAdmin = User::factory()->make(['id' => 2]);
        $company = $this->createCompany($admin);
        $truck = $this->createTruck($company->id);
        $client = $this->createClient(2);
        $location = $this->createLocation($client->id);

        [$orderRepo] = $this->mockDependencies($noneAdmin);


        $this->expectException(\Exception::class);

        /** @var OrderManagerServiceInterface $service */
        $service = resolve(OrderManagerService::class);

        $data = new NewOrderData(
            $company, $client, $location, $truck
        );

        $order = $service->createOrder($data);
    }

    public function test_admin_cannot_create_order_with_invalid_location(): void
    {
        $admin = User::factory()->make(['id' => 1]);
        $noneAdmin = User::factory()->make(['id' => 2]);
        $company = $this->createCompany($admin);
        $truck = $this->createTruck($company->id);
        $client = $this->createClient($company->id);
        $location = $this->createLocation(2);

        [$orderRepo] = $this->mockDependencies($noneAdmin);


        $this->expectException(\Exception::class);

        /** @var OrderManagerServiceInterface $service */
        $service = resolve(OrderManagerService::class);

        $data = new NewOrderData(
            $company, $client, $location, $truck
        );

        $order = $service->createOrder($data);
    }

    public function test_admin_cannot_create_order_with_invalid_truck(): void
    {
        $admin = User::factory()->make(['id' => 1]);
        $noneAdmin = User::factory()->make(['id' => 2]);
        $company = $this->createCompany($admin);
        $truck = $this->createTruck(2);
        $client = $this->createClient($company->id);
        $location = $this->createLocation($client->id);


        [$orderRepo] = $this->mockDependencies($noneAdmin);


        $this->expectException(\Exception::class);

        /** @var OrderManagerServiceInterface $service */
        $service = resolve(OrderManagerService::class);

        $data = new NewOrderData(
            $company, $client, $location, $truck
        );

        $order = $service->createOrder($data);
    }


    public function mockOrderRepo(): OrderMemoryRepository
    {
        $memory = new OrderMemoryRepository();
        $this->app->bind(OrderRepositoryInterface::class, function () use ($memory) {
            return $memory;
        });
        return $memory;
    }


    public function mockDependencies(User $admin): array
    {
        $orderRepo = $this->mockOrderRepo();

        $this->mock(Guard::class)
            ->shouldReceive('user')
            ->andReturn($admin);

        return [$orderRepo];
    }


    public function createLocation(int $client_id): Location
    {
        return Location::factory()->make([
            "id" => 1,
            "client_id" => $client_id
        ]);
    }

    public function createClient(int $company_id): Client
    {
        return Client::factory()->make([
            'id' => 1,
            'company_id' => $company_id,
        ]);
    }

    public function createTruck(int $company_id): Truck
    {
        return Truck::factory()->make([
            'id' => 1,
            'company_id' => $company_id
        ]);
    }

    /**
     * @param User|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection $admin
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|Company
     */
    public function createCompany(User|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection $admin): Company|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
    {
        return Company::factory()->make([
            "id" => 1,
            "admin_id" => $admin->id
        ]);
    }
}
