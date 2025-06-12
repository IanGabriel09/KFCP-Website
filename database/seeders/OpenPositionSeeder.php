<?php

namespace Database\Seeders;

use Database\Factories\OpenPositionFactory;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OpenPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OpenPositionFactory::new()->count(10)->create();
    }
}
