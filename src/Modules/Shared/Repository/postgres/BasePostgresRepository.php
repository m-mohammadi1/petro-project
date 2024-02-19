<?php

namespace Modules\Shared\Repository\postgres;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Shared\Repository\BaseRepositoryInterface;

abstract class BasePostgresRepository implements BaseRepositoryInterface
{
    protected abstract function getModel(): string;

    public function create(array $data): Model
    {
        return $this->getQuery()->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->getQuery()
            ->where('id', $id)
            ->update($data);
    }

    public function delete(int $id): bool
    {
        return $this->getQuery()
            ->where('id', $id)
            ->delete();
    }

    public function all(array $conditions): Collection
    {
        $conds = [];
        foreach ($conditions as $field => $value) {
            $conds[] = [$field, "=", $value];
        }

        return $this->getQuery()->where($conds)->get();
    }

    public function paginate(array $conditions, int $perPage = 25): LengthAwarePaginator
    {
        $conds = [];
        foreach ($conditions as $field => $value) {
            $conds[] = [$field, "=", $value];
        }

        return $this->getQuery()->where($conds)->paginate(25);
    }

    public function find(int $id): ?Model
    {
        return $this->getQuery()->find($id);
    }

    public function findOrFail(int $id): Model
    {
        return $this->getQuery()->findOrFail($id);
    }

    public function getQuery(): Builder
    {
        return resolve($this->getModel())->query();
    }
}
