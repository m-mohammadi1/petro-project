<?php

namespace Modules\Shared\Repository\memory;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Shared\Repository\BaseRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class BaseMemoryRepository implements BaseRepositoryInterface
{
    private array $storage = [];

    public function __construct(array $initialValues = [])
    {
        $this->storage = $initialValues;
    }

    protected abstract function getModel(): string;

    public function create(array $data): Model
    {
        $idToInsert = count($this->storage) + 1;

        $model = resolve($this->getModel());
        $model->id = $idToInsert;
        foreach ($data as $field => $value) {
            $model->{$field} = $value;
        }

        $model->created_at = Carbon::now();
        $model->updated_at = Carbon::now();


        $this->storage = [
            ...$this->storage,
            $idToInsert => $model,
        ];


        return $model;
    }

    public function update(int $id, array $data): bool
    {
        $model = collect($this->storage)->where('id', $id)->first();

        if (!$model) {
            throw new NotFoundHttpException("model not found");
        }

        foreach ($data as $field => $value) {
            $model->{$field} = $value;
        }

        $model->updated_at = Carbon::now();

        $this->storage = [
            ...$this->storage,
            $model->id => $model,
        ];

        return true;
    }

    public function delete(int $id): bool
    {
        $model = collect($this->storage)->where('id', $id)->first();

        if (!$model) {
            throw new NotFoundHttpException("model not found");
        }

        unset($this->storage[$id]);

        return true;
    }

    public function all(array $conditions): Collection
    {
        $result = collect($this->storage);

        foreach ($conditions as $key => $value) {
            $result = $result->where($key, $value);
        }

        return $result;
    }

    public function paginate(array $conditions, int $perPage = 25): LengthAwarePaginator
    {
        $result = collect($this->storage);

        foreach ($conditions as $key => $value) {
            $result = $result->where($key, $value);
        }

        return LengthAwarePaginator::make($result->take($perPage)->toArray());
    }

    public function find(int $id): ?Model
    {
        $model = collect($this->storage)->where('id', $id)->first();

        return $model;
    }

    public function findOrFail(int $id): Model
    {
        $model = collect($this->storage)->where('id', $id)->first();

        if (!$model) {
            throw new NotFoundHttpException("model not found");
        }

        return $model;
    }
}
