<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Admin::factory()->create([
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
        ]);
    }
}
