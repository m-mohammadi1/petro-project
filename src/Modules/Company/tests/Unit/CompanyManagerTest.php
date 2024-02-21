<?php

namespace Modules\Company\tests\Unit;

use Illuminate\Contracts\Auth\Guard;
use Modules\Auth\App\Models\User;
use Modules\Auth\Services\AccessChecker\AccessCheckerServiceInterface;
use Modules\Company\Repository\Company\CompanyMemoryRepository;
use Modules\Company\Repository\Company\CompanyRepositoryInterface;
use Modules\Company\Services\CompanyManager\CompanyManagerService;
use Modules\Company\Services\CompanyManager\CompanyManagerServiceInterface;
use Tests\TestCase;

class CompanyManagerTest extends TestCase
{
    public function test_super_admin_can_create_company(): void
    {
        $superAdmin = User::factory()->make([
            'id' => 1
        ]);

        $memory = $this->mockRepository();
        $this->mockAuthGaurd($superAdmin);
        $this->mockAccessChecker();


        /** @var CompanyManagerServiceInterface $service */
        $service = resolve(CompanyManagerService::class);

        $admin = User::factory()->make(['id' => 2]);
        $company = $service->createCompany("test-name", $admin);

        $this->assertEquals($company->name, "test-name");
        $storedModel = $memory->find($company->id);
        $this->assertNotNull($storedModel);
        $this->assertEquals($storedModel->id, $company->id);
    }

    public function test_non_super_user_cannot_create_company()
    {
        $user = User::factory()->make([
            'id' => 1
        ]);

        $memory = $this->mockRepository();
        $this->mockAuthGaurd($user);
        $this->mockAccessChecker(false);

        /** @var CompanyManagerServiceInterface $service */
        $service = resolve(CompanyManagerService::class);

        $this->expectException(\Exception::class);

        $admin = User::factory()->make(['id' => 2]);
        $service->createCompany("test", $admin);

        $this->assertEmpty($memory->all([]));
    }

    public function test_super_admin_can_delete_company()
    {
        $superAdmin = User::factory()->make([
            'id' => 1
        ]);

        $memory = $this->mockRepository();
        $this->mockAuthGaurd($superAdmin);
        $this->mockAccessChecker();


        /** @var CompanyManagerServiceInterface $service */
        $service = resolve(CompanyManagerService::class);


        $admin = User::factory()->make([
            'id' => 2
        ]);
        // create a company
        $createdModel = $memory->create([
            "name" => "test",
            "admin_id" => $admin->id,
        ]);

        $service->deleteCompany($createdModel->id);

        $deletedModel = $memory->find($createdModel->id);
        $this->assertNull($deletedModel);
    }

    public function test_non_super_user_cannot_delete_company()
    {
        $user = User::factory()->make([
            'id' => 1
        ]);

        $memory = $this->mockRepository();
        $this->mockAuthGaurd($user);
        $this->mockAccessChecker(false);

        /** @var CompanyManagerServiceInterface $service */
        $service = resolve(CompanyManagerService::class);

        $this->expectException(\Exception::class);

        $admin = User::factory()->make(['id' => 2]);
        $createdModel = $memory->create([
            "name" => "test",
            "admin_id" => $admin->id,
        ]);

        $service->deleteCompany($createdModel->id);

        $deletingModel = $memory->find($createdModel->id);
        $this->assertNotNull($deletingModel);
    }


    /**
     * @return CompanyMemoryRepository
     */
    public function mockRepository(): CompanyMemoryRepository
    {
        $memory = new CompanyMemoryRepository();
        $this->app->bind(CompanyRepositoryInterface::class, function () use ($memory) {
            return $memory;
        });
        return $memory;
    }

    /**
     * @param User|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection $superAdmin
     * @return void
     */
    public function mockAuthGaurd(User|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection $superAdmin): void
    {
        $gourd = $this->mock(Guard::class)
            ->shouldReceive('user')
            ->andReturn($superAdmin);
    }

    /**
     * @return void
     */
    public function mockAccessChecker($access = true): void
    {
        $accessChecker = $this->mock(AccessCheckerServiceInterface::class)
            ->shouldReceive('isUserSuperAdmin')
            ->andReturn($access);
    }
}
