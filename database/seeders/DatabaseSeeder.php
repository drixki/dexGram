<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::create([
            'name' => 'Yappp',
            'email' => 'user@gmail.com',
            'password' => Hash::make('12345678')
        ]);

        $faker = Faker::create('id_ID'); // Menggunakan bahasa Indonesia

        foreach (range(1, 100) as $index) {
            \App\Models\User::factory()->create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('12345678')
            ]);
        }
    }
}
