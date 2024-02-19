<?php

namespace Modules\Auth\Repository\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Auth\App\Models\User;
use Modules\Shared\Repository\postgres\BasePostgresRepository;

class UserPostgresRepository extends BasePostgresRepository implements UserRepositoryInterface
{

    protected function getModel(): string
    {
        return User::class;
    }
}
