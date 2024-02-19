<?php

namespace Modules\Auth\Repository\Role;

use Modules\Auth\App\Models\Role;
use Modules\Shared\Repository\memory\BaseMemoryRepository;

class RoleMemoryRepository extends BaseMemoryRepository implements RoleRepositoryInterface
{
    protected function getModel(): string
    {
        return Role::class;
    }

    public function roleExistsWithSameName(string $name): bool
    {
        return $this->all(['name' => $name])->count() > 0;
    }
}
