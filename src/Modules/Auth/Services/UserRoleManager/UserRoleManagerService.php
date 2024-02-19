<?php

namespace Modules\Auth\Services\UserRoleManager;

use Modules\Auth\App\Models\Role;
use Modules\Auth\App\Models\User;
use Modules\Auth\Repository\Role\RoleRepositoryInterface;
use Modules\Auth\Repository\User\UserRepositoryInterface;

class UserRoleManagerService implements UserRoleManagerServiceInterface
{
    private User $user;

    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly RoleRepositoryInterface $roleRepository,
    )
    {
    }

    public function withUser(User $user): UserRoleManagerServiceInterface
    {
        $this->user = $user;

        return $this;
    }

    public function assignRole(int $roleId): User
    {
        $this->checkUserIsSet();

        $result = $this->userRepository->update($this->user->id, [
            'role_id' => $roleId
        ]);

        if (!$result) {
            throw new \Exception("cannot assign role to user.");
        }

        return $this->user;
    }

    public function getRole(): Role
    {
        $this->checkUserIsSet();

        $role = $this->roleRepository->find(
            $this->user->role_id
        );

        if (!$role) {
            throw new \Exception("user does not have any roles.");
        }

        return $role;
    }

    public function detachRole(): User
    {
        $this->checkUserIsSet();

        $result = $this->userRepository->update($this->user->id, [
            'role_id' => null
        ]);

        if (!$result) {
            throw new \Exception("cannot detach role from user.");
        }

        return $this->user;
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function checkUserIsSet(): void
    {
        if (!isset($this->user)) {
            throw new \Exception("provide user to assign role.");
        }
    }
}
