<?php

namespace Database\Factories;
use App\Models\OpenPositionModel;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OpenPositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = OpenPositionModel::class;

    public function definition(): array
    {
        return [
            'UID' => $this->faker->uuid,
            'pos_name' => $this->faker->jobTitle,
            'pos_quantity' => $this->faker->randomElement(['Multiple', 'Single']),
            'job_type' => $this->faker->randomElement(['Full-Time', 'Part-Time', 'Contract', 'Internship']),
            'job_description' => $this->faker->paragraph,
            'qualifications' => $this->faker->sentences(3),
            'benefits' => $this->faker->sentences(3),
        ];
    }
}
