<?php

namespace Modules\Auth\Services\UserRoleManager;

use Modules\Auth\App\Models\Role;
use Modules\Auth\App\Models\User;

interface UserRoleManagerServiceInterface
{
    public function withUser(User $user): self;

    public function assignRole(int $roleId): User;

    public function getRole(): Role;

    public function detachRole(): User;
}
