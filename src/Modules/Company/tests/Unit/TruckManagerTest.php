<?php

namespace Modules\Company\tests\Unit;

use Illuminate\Contracts\Auth\Guard;
use Modules\Auth\App\Models\User;
use Modules\Auth\Services\AccessChecker\AccessCheckerServiceInterface;
use Modules\Company\Repository\Company\CompanyMemoryRepository;
use Modules\Company\Repository\Company\CompanyRepositoryInterface;
use Modules\Company\Repository\Truck\TruckMemoryRepository;
use Modules\Company\Repository\Truck\TruckRepositoryInterface;
use Modules\Company\Services\CompanyManager\CompanyManagerService;
use Modules\Company\Services\CompanyManager\CompanyManagerServiceInterface;
use Modules\Company\Services\TruckManager\TruckManagerService;
use Modules\Company\Services\TruckManager\TruckManagerServiceInterface;
use Modules\Company\Services\TruckManager\Types\CreateTruckData;
use Tests\TestCase;

class TruckManagerTest extends TestCase
{
    public function test_admin_can_create_truck(): void
    {
        $admin = User::factory()->make([
            'id' => 1
        ]);

        [$companyRepo, $truckRepo] = $this->mockDependencies($admin);

        // create company
        $company = $companyRepo->create([
            "name" => "test 1",
            "admin_id" => $admin->id,
        ]);


        /** @var TruckManagerServiceInterface $service */
        $service = resolve(TruckManagerService::class);


        $truck = $service->addTruckToCompany(new CreateTruckData($company->id, "Mohammad Mohammadi"));


        // check it is stored
        $storedTruck = $truckRepo->find($truck->id);

        $this->assertNotNull($storedTruck);
        $this->assertEquals($truck->driver_name, "Mohammad Mohammadi");
        $this->assertEquals($truck->company_id, $company->id);
    }

    public function test_non_admin_cannot_create_truck(): void
    {
        $admin = User::factory()->make([
            'id' => 1
        ]);
        $noneAdmin = User::factory()->make([
            'id' => 2
        ]);

        [$companyRepo, $truckRepo] = $this->mockDependencies($noneAdmin);

        // create company
        $company = $companyRepo->create([
            "name" => "test 1",
            "admin_id" => $admin->id,
        ]);


        /** @var TruckManagerServiceInterface $service */
        $service = resolve(TruckManagerService::class);

        $this->expectException(\Exception::class);

        $truck = $service->addTruckToCompany(new CreateTruckData($company->id, "Mohammad Mohammadi"));
    }


    public function test_admin_can_delete_truck(): void
    {
        $admin = User::factory()->make([
            'id' => 1
        ]);

        [$companyRepo, $truckRepo] = $this->mockDependencies($admin);

        // create company
        $company = $companyRepo->create([
            "name" => "test 1",
            "admin_id" => $admin->id,
        ]);


        /** @var TruckManagerServiceInterface $service */
        $service = resolve(TruckManagerService::class);

        $truck = $truckRepo->create([
            "company_id" => $company->id,
            "driver_name" => "Mohammad Mohammadi",
        ]);

        // delete
        $service->deleteTruck($truck->id);

        $deletedTruck = $truckRepo->find($truck->id);
        $this->assertNull($deletedTruck);
    }

    public function test_none_admin_cannot_delete_truck(): void
    {
        $admin = User::factory()->make([
            'id' => 1
        ]);
        $noneAdmin = User::factory()->make([
            'id' => 2
        ]);

        [$companyRepo, $truckRepo] = $this->mockDependencies($noneAdmin);

        // create company
        $company = $companyRepo->create([
            "name" => "test 1",
            "admin_id" => $admin->id,
        ]);


        /** @var TruckManagerServiceInterface $service */
        $service = resolve(TruckManagerService::class);

        $truck = $truckRepo->create([
            "company_id" => $company->id,
            "driver_name" => "Mohammad Mohammadi",
        ]);

        $this->expectException(\Exception::class);
        // delete
        $service->deleteTruck($truck->id);

        $deletedTruck = $truckRepo->find($truck->id);
        $this->assertNotNull($deletedTruck);
    }


    public function mockCompanyRepo(): CompanyMemoryRepository
    {
        $memory = new CompanyMemoryRepository();
        $this->app->bind(CompanyRepositoryInterface::class, function () use ($memory) {
            return $memory;
        });
        return $memory;
    }

    public function mockTruckRepo(): TruckMemoryRepository
    {
        $memory = new TruckMemoryRepository();
        $this->app->bind(TruckRepositoryInterface::class, function () use ($memory) {
            return $memory;
        });
        return $memory;
    }


    public function mockDependencies(User $admin): array
    {
        $companyRepo = $this->mockCompanyRepo();
        $truckRepo = $this->mockTruckRepo();
        $this->mock(Guard::class)
            ->shouldReceive('user')
            ->andReturn($admin);

        return [$companyRepo, $truckRepo];
    }
}
