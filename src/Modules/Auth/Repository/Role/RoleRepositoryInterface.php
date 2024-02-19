<?php

namespace Modules\Auth\Repository\Role;

use Modules\Auth\App\Models\Role;
use Modules\Shared\Repository\BaseRepositoryInterface;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{
    public function roleExistsWithSameName(string $name): bool;

    public function findByName(string $name): ?Role;
}
