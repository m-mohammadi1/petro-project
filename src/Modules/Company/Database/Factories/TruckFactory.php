<?php

namespace Modules\Company\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Company\App\Models\Company;

class TruckFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Company\App\Models\Truck::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'driver_name' => $this->faker->name,
            'company_id' => Company::factory(),
        ];
    }
}

