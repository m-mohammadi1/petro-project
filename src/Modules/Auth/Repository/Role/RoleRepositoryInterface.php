<?php

namespace Modules\Auth\Repository\Role;

use Modules\Shared\Repository\BaseRepositoryInterface;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{
    public function roleExistsWithSameName(string $name): bool;

}
