<?php

namespace Modules\Client\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Client\App\Http\Requests\CreateClientRequest;
use Modules\Client\App\resources\ClientResource;
use Modules\Client\Services\ClientManager\ClientManagerServiceInterface;
use Modules\Client\Services\ClientManager\Types\ClientCreateData;

class CreateClientController extends Controller
{
    public function __construct(
        private readonly ClientManagerServiceInterface $clientManagerService
    )
    {
    }


    /**
     * creates a client with company and locations provided.
     *
     * @param CreateClientRequest $request
     * @return ClientResource
     */
    public function __invoke(CreateClientRequest $request): ClientResource
    {
        $data = new ClientCreateData(
            $request->input('company_id'),
            $request->input('name'),
            $request->json('locations'),
        );

        $client = $this->clientManagerService->createClient($data);

        return ClientResource::make($client);
    }
}
