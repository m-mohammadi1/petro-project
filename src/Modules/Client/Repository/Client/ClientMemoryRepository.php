<?php

namespace Modules\Client\Repository\Client;

use Modules\Client\App\Models\Client;
use Modules\Shared\Repository\memory\BaseMemoryRepository;

class ClientMemoryRepository extends BaseMemoryRepository implements ClientRepositoryInterface
{
    protected function getModel(): string
    {
        return Client::class;
    }
}
