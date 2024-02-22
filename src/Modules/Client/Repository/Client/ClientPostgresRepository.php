<?php

namespace Modules\Client\Repository\Client;

use Modules\Client\App\Models\Client;
use Modules\Shared\Repository\postgres\BasePostgresRepository;

class ClientPostgresRepository extends BasePostgresRepository implements ClientRepositoryInterface
{
    protected function getModel(): string
    {
        return Client::class;
    }
}
