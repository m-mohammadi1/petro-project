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
use Modules\Company\Repository\Company\CompanyMemoryRepository;
use Modules\Company\Repository\Company\CompanyRepositoryInterface;
use Tests\TestCase;

class ClientManagerTest extends TestCase
{
    public function test_admin_can_create_client_with_locations(): void
    {
        $admin = User::factory()->make([
            'id' => 1
        ]);

        [$clientRepo, $locRepo, $companyRepo] = $this->mockDependencies($admin);

        $company = $companyRepo->create(Company::factory()->make([
            "admin_id" => $admin->id,
        ])->toArray());

        // create client with locations
        /** @var ClientManagerServiceInterface $service */
        $service = resolve(ClientManagerService::class);

        $clientData = new ClientCreateData($company->id, "test-name", [
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



    public function mockDependencies(User $admin): array
    {
        $clientRepo = $this->mockRepo(ClientRepositoryInterface::class, ClientMemoryRepository::class);
        $locRepo = $this->mockRepo(LocationRepositoryInterface::class, LocationMemoryRepository::class);
        $companyRepo = $this->mockRepo(CompanyRepositoryInterface::class, CompanyMemoryRepository::class);


        $this->mock(Guard::class)
            ->shouldReceive('id')
            ->andReturn($admin->id);

        return [$clientRepo, $locRepo, $companyRepo];
    }
}
