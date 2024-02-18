<?php

namespace Modules\Shared\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{
    public function create(array $data): Model;

    /**
     * update and get the result accuracy
     */
    public function update(int $id, array $data): bool;

    /**
     * delete and get the result accuracy
     */
    public function delete(int $id): bool;

    public function all(array $conditions): Collection;

    public function paginate(array $conditions, int $perPage = 25): LengthAwarePaginator;

    public function findOrFail(int $id): Model;
}
