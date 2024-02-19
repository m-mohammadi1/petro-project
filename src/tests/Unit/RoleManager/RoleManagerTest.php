<?php

namespace Tests\Unit\RoleManager;

use Modules\Auth\Repository\Role\RoleMemoryRepository;
use Modules\Auth\Repository\User\UserMemoryRepository;
use Modules\Auth\Services\RegisterUser\RegisterUserService;
use Modules\Auth\Services\RegisterUser\Types\RegisterUserData;
use Modules\Auth\Services\RoleManager\RoleManagerService;
use Modules\Auth\Services\UserRoleManager\UserRoleManagerService;
use Tests\TestCase;

class RoleManagerTest extends TestCase
{
    public function test_it_can_create_role(): void
    {
        $memory = new RoleMemoryRepository();

        $service = new RoleManagerService($memory);

        $role = $service->addRole('admin');
        $createdRole = $memory->find($role->id);
        $this->assertEquals($createdRole->name, $role->name);
    }

    public function test_it_cannot_create_role_with_existing_name(): void
    {
        $memory = new RoleMemoryRepository();

        $service = new RoleManagerService($memory);

        $service->addRole('admin');

        $this->expectException(\Exception::class);
        // create role with same name
        $service->addRole('admin');
    }

    public function test_it_can_delete_role()
    {
        $memory = new RoleMemoryRepository();

        $service = new RoleManagerService($memory);

        $role = $service->addRole('admin');

        $service->deleteRole($role->id);

        $removedRole = $memory->find($role->id);

        $this->assertNull($removedRole);
    }
}
