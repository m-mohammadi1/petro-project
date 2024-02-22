<?php

namespace Modules\Client\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateClientRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'company_id' => ['required'],
            'name' => ['required', 'max:256'],
            'locations' => ['required', 'array'],
            'locations.*.title' => ['required'],
            'locations.*.lat' => ['required'],
            'locations.*.lon' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
