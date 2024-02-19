<?php

namespace Modules\Auth\Services\RoleManager;

use Modules\Auth\App\Models\Role;
use Modules\Auth\Repository\Role\RoleRepositoryInterface;

class RoleManagerService implements RoleManagerServiceInterface
{
    public function __construct(
        private readonly RoleRepositoryInterface $roleRepository,
    )
    {
    }

    public function addRole(string $name): Role
    {
        $roleExists = $this->roleRepository->roleExistsWithSameName($name);

        if ($roleExists) {
            throw new \Exception("role exists with same name");
        }

        return $this->roleRepository->create([
            'name' => $name
        ]);
    }

    public function deleteRole(int $id): void
    {
        $result = $this->roleRepository->delete($id);

        if (!$result) {
            throw new \Exception("role cannot be deleted.");
        }
    }

    public function updateRole(int $id, string $newName)
    {
        $roleExists = $this->roleRepository->roleExistsWithSameName($newName);

        if ($roleExists) {
            throw new \Exception("role exists with same name");
        }

        $result = $this->roleRepository->update($id, [
            'name' => $newName
        ]);

        if (!$result) {
            throw new \Exception("role cannot be deleted.");
        }
    }
}
