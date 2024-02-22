<?php

namespace Modules\Client\Services\ClientManager;

use Modules\Client\App\Models\Client;
use Modules\Client\Services\ClientManager\Types\ClientCreateData;

interface ClientManagerServiceInterface
{
    public function createClient(ClientCreateData $clientData): Client;
}
