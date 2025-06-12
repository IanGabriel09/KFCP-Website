<?php

namespace Database\Seeders;

use App\Models\AdminModel;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdminModel::create([
            'uuid' => Str::uuid(),
            'username' => 'admin1',
            'password' => Hash::make('asd123'), // Always hash passwords
        ]);

        AdminModel::create([
            'uuid' => Str::uuid(),
            'username' => 'admin2',
            'password' => Hash::make('asd123'), // Always hash passwords
        ]);
    }
}
