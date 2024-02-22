<?php

namespace Modules\Client\App\resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Client\App\Models\Client;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        /** @var Client|self $this  */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'company_id' => $this->company_id,
        ];
    }
}
