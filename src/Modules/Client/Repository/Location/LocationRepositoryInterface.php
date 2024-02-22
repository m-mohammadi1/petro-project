<?php

namespace Modules\Client\Repository\Location;

use Modules\Shared\Repository\BaseRepositoryInterface;

interface LocationRepositoryInterface extends BaseRepositoryInterface
{
    public function createLocations(int $client_id, array $locations): void;
}
