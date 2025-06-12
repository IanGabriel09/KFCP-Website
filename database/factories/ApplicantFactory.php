<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ApplicantsModel;
use App\Models\OpenPositionModel;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ApplicantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    
    // Explicitly link the factory to the model
    protected $model = ApplicantsModel::class;

    public function definition(): array
    {
        // Get a random position from open_positions
        $position = OpenPositionModel::inRandomOrder()->first();

        if (!$position) {
            throw new \Exception('No open positions available. Seed open_positions table first.');
        }

        return [
            'application_id' => Str::uuid(),
            'application_status' => null,
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'contact' => $this->faker->phoneNumber(),
            'selected_position_id' => $position->UID,
            'selected_position' => $position->position_name,
            'subject' => 'Application for ' . $position->position_name,
            'mssg' => $this->faker->paragraph(),
            'gdrive_folderlink' => $this->faker->url(),
            'cv_drive_name' => $this->faker->slug . '.pdf',
        ];
    }

}
