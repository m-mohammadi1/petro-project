<?php

namespace Modules\Client\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Client\App\Models\Client::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

