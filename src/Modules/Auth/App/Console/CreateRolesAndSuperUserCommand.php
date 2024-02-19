<?php

namespace Modules\Auth\App\Console;

use Illuminate\Console\Command;
use Modules\Auth\Repository\Role\RoleRepositoryInterface;
use Modules\Auth\Repository\User\UserRepositoryInterface;
use Modules\Auth\Services\RoleManager\RoleManagerService;
use Modules\Auth\Services\RoleManager\RoleManagerServiceInterface;
use Modules\Auth\Services\UserRoleManager\UserRoleManagerServiceInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreateRolesAndSuperUserCommand extends Command
{
    protected $signature = 'auth:init';


    protected $description = 'creates default roles and a super user';


    public function handle()
    {
        /** @var RoleManagerService $roleService */
        /** @var UserRepositoryInterface $userRepo */
        $roleRepo = resolve(RoleRepositoryInterface::class);
        $userRepo = resolve(UserRepositoryInterface::class);

        $roleService = resolve(RoleManagerServiceInterface::class, [$roleRepo]);

        // create role or get it
        try {
            $role = $roleService->addRole('super-admin');
        } catch (\Exception $e) {
            $role = $roleService->getRole('super-admin');
        }

        // create user
        $user = $userRepo->all([
            'email' => 'admin@admin.com'
        ])->first();

        if (!$user) {
            $user = $userRepo->create([
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('12345678')
            ]);
        }

        $userRepo->update($user->id, [
            'role_id' => $role->id
        ]);
    }
}
