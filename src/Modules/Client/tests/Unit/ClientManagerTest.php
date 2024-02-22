<?php

namespace Modules\Client\tests\Unit;

use Illuminate\Contracts\Auth\Guard;
use Modules\Auth\App\Models\User;
use Modules\Client\Repository\Client\ClientMemoryRepository;
use Modules\Client\Repository\Client\ClientRepositoryInterface;
use Modules\Client\Repository\Location\LocationMemoryRepository;
use Modules\Client\Repository\Location\LocationRepositoryInterface;
use Modules\Client\Services\ClientManager\ClientManagerService;
use Modules\Client\Services\ClientManager\ClientManagerServiceInterface;
use Modules\Client\Services\ClientManager\Types\ClientCreateData;
use Modules\Client\Services\ClientManager\Types\LocationData;
use Modules\Company\App\Models\Company;
use Tests\TestCase;

class ClientManagerTest extends TestCase
{
    public function test_admin_can_create_client_with_locations(): void
    {
        $admin = User::factory()->make([
            'id' => 1
        ]);

        [$clientRepo, $locRepo] = $this->mockDependencies($admin);

        $company = Company::factory()->make([
            "id" => 1,
            "admin_id" => $admin->id,
        ]);

        // create client with locations
        /** @var ClientManagerServiceInterface $service */
        $service = resolve(ClientManagerService::class);

        $clientData = new ClientCreateData($company, "test-name", [
            new LocationData("name-1", 22.222, 11.111),
            new LocationData("name-2", 33.333, 44.444),
        ]);
        $client = $service->createClient($clientData);

        $this->assertNotNull($client);

        $createdClient = $clientRepo->find($client->id);
        $this->assertEquals($client->name, $createdClient->name);

        $locations = $locRepo->all();
        $this->assertCount(2, $locations);
    }


    public function mockClientRepo(): ClientMemoryRepository
    {
        $memory = new ClientMemoryRepository();
        $this->app->bind(ClientRepositoryInterface::class, function () use ($memory) {
            return $memory;
        });
        return $memory;
    }

    public function mockLocationRepo(): LocationMemoryRepository
    {
        $memory = new LocationMemoryRepository();
        $this->app->bind(LocationRepositoryInterface::class, function () use ($memory) {
            return $memory;
        });
        return $memory;
    }


    public function mockDependencies(User $admin): array
    {
        $clientRepo = $this->mockClientRepo();
        $locRepo = $this->mockLocationRepo();

        $this->mock(Guard::class)
            ->shouldReceive('id')
            ->andReturn($admin->id);

        return [$clientRepo, $locRepo];
    }
}
