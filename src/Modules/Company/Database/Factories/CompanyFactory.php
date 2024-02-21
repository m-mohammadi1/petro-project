<?php

namespace Modules\Company\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Auth\App\Models\User;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Company\App\Models\Company::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'admin_id' => User::factory(),
            'name' => $this->faker->text(40),
        ];
    }
}

