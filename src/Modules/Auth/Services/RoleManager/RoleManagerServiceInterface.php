<?php

namespace Modules\Auth\Services\RoleManager;

use Modules\Auth\App\Models\Role;

interface RoleManagerServiceInterface
{
    public function addRole(string $name): Role;

    public function deleteRole(int $id): void;

    public function updateRole(int $id, string $newName);
}
