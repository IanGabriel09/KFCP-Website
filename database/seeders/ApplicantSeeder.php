<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use App\Models\OpenPositionModel;

class ApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get all valid positions [UID => position_name]
        $positions = OpenPositionModel::pluck('pos_name', 'UID')->toArray();

        if (empty($positions)) {
            throw new \Exception('No open positions found. Seed open_positions table first.');
        }

        $applicants = [];

        for ($i = 0; $i < 10; $i++) {
            // Pick a random position UID and name
            $positionUID = $faker->randomElement(array_keys($positions));
            $positionName = $positions[$positionUID];

            $applicants[] = [
                'application_id' => Str::uuid(),
                'application_status' => null,
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => $faker->unique()->safeEmail(),
                'contact' => $faker->phoneNumber(),
                'selected_position_id' => $positionUID,
                'selected_position' => $positionName,
                'subject' => 'Application for ' . $positionName,
                'mssg' => $faker->paragraph(),
                'gdrive_folderlink' => $faker->url(),
                'cv_drive_name' => $faker->slug . '.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Bulk insert all 10 applicants
        DB::table('applicants')->insert($applicants);
    }
}
