<?php

namespace Modules\Auth\Repository\Role;

use Modules\Auth\App\Models\Role;
use Modules\Shared\Repository\memory\BaseMemoryRepository;
use Modules\Shared\Repository\postgres\BasePostgresRepository;

class RolePostgresRepository extends BasePostgresRepository implements RoleRepositoryInterface
{
    protected function getModel(): string
    {
        return Role::class;
    }

    public function roleExistsWithSameName(string $name): bool
    {
        return $this->getQuery()->where('name', $name)->exists();
    }

    public function findByName(string $name): ?Role
    {
        return $this->getQuery()->where('name', $name)->first();
    }
}
