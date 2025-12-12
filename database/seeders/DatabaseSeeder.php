<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Note: This is a frontend-only application.
     * All data seeding should be done in the backend API.
     */
    public function run(): void
    {
        $this->command->info('ℹ️  Frontend does not seed data. Use backend API for seeding.');
    }
}
