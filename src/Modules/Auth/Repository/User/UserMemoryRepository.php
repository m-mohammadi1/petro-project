<?php

namespace Modules\Auth\Repository\User;

use Modules\Auth\App\Models\User;
use Modules\Shared\Repository\memory\BaseMemoryRepository;

class UserMemoryRepository extends BaseMemoryRepository implements UserRepositoryInterface
{
    protected function getModel(): string
    {
        return User::class;
    }
}
