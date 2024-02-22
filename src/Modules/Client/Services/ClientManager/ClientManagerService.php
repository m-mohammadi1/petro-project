<?php

namespace Modules\Client\Services\ClientManager;

use Illuminate\Contracts\Auth\Guard;
use Modules\Client\App\Models\Client;
use Modules\Client\Repository\Client\ClientRepositoryInterface;
use Modules\Client\Repository\Location\LocationRepositoryInterface;
use Modules\Client\Services\ClientManager\Types\ClientCreateData;
use Modules\Company\Repository\Company\CompanyRepositoryInterface;

class ClientManagerService implements ClientManagerServiceInterface
{
    public function __construct(
        public readonly Guard                       $guard,
        public readonly ClientRepositoryInterface   $clientRepository,
        public readonly LocationRepositoryInterface $locationRepository,
    )
    {
    }

    public function createClient(ClientCreateData $clientData): Client
    {
        // check user
        $company = $clientData->company;

        if ($this->guard->id() !== $company->admin_id) {
            throw new \Exception("only company admin can create clients for it.");
        }

        $client = $this->clientRepository->create([
            "name" => $clientData->name,
            "company_id" => $clientData->company->id,
        ]);

        // add locations for the client
        $this->locationRepository->createLocations($client->id, $clientData->locationsToArray());


        return $client;
    }
}
