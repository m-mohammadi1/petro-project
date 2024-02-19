<?php

namespace Tests\Unit\UserRoleManager;

use Modules\Auth\Repository\Role\RoleMemoryRepository;
use Modules\Auth\Repository\User\UserMemoryRepository;
use Modules\Auth\Services\RegisterUser\RegisterUserService;
use Modules\Auth\Services\RegisterUser\Types\RegisterUserData;
use Modules\Auth\Services\UserRoleManager\UserRoleManagerService;
use Tests\TestCase;

class UserRoleManagerTest extends TestCase
{
    public function test_it_can_assign_role_to_user(): void
    {
        $memoryUser = new UserMemoryRepository();
        $memoryRole = new RoleMemoryRepository();

        $memoryRole->create([
            'name' => 'admin'
        ]);

        $userRegistered = $this->getRegisteredUser($memoryUser);
        $roleService = $this->getUserRoleManagerService($memoryUser, $memoryRole, $userRegistered);


        // assign role to user
        $roleId = 1;
        $roleService->assignRole($roleId);

        // check to see user has the created role_id
        $user = $memoryUser->find($userRegistered->id);

        $this->assertEquals(1, $user->role_id, "does not assigned role to user");

        $assignedRole = $roleService->getRole();
        $this->assertEquals(1, $assignedRole->id);
        $this->assertEquals('admin', $assignedRole->name);
    }

    public function test_it_can_detach_role_from_user()
    {
        $memoryUser = new UserMemoryRepository();
        $memoryRole = new RoleMemoryRepository();



        $userRegistered = $this->getRegisteredUser($memoryUser);
        $roleService = $this->getUserRoleManagerService($memoryUser, $memoryRole, $userRegistered);


        $roleService->withUser($userRegistered)
            ->assignRole(1);
        $roleService->detachRole();

        $user = $memoryUser->find($userRegistered->id);

        $this->assertNull($user->role_id);
    }

    public function getRegisteredUser(UserMemoryRepository $memoryUser): \Modules\Auth\App\Models\User
    {
        $userService = new RegisterUserService($memoryUser);

        return $userService->register(new RegisterUserData(
            "Admin",
            "mohammad@mohammadi.com",
            "12345678"
        ));
    }


    public function getUserRoleManagerService(UserMemoryRepository $memoryUser, RoleMemoryRepository $memoryRole, \Modules\Auth\App\Models\User $userRegistered): \Modules\Auth\Services\UserRoleManager\UserRoleManagerServiceInterface
    {
        $memoryRole->create([
            'name' => 'admin'
        ]);

        $roleService = new UserRoleManagerService($memoryUser, $memoryRole);
        $roleService = $roleService->withUser($userRegistered);
        return $roleService;
    }
}
