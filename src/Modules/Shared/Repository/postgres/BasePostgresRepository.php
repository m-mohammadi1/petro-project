<?php

namespace Modules\Shared\Repository\postgres;

use Illuminate\Support\Collection;
use Modules\Shared\Repository\BaseRepositoryInterface;

abstract class BasePostgresRepository implements BaseRepositoryInterface
{
    protected abstract function getModel(): string;
}
