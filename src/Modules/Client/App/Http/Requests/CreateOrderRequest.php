<?php

namespace Modules\Client\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "company_id" => ['required'],
            "client_id" => ['required'],
            "location_id" => ['required'],
            "truck_id" => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
