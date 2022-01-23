<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cat;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::factory()->create(['email' => 'user1@example.com']);
        User::factory()->create(['email' => 'user2@example.com']);
        User::factory()->create(['email' => 'user3@example.com']);

        // cats
        Cat::factory()->create([
            'user_id' => $user1->id,
        ]);
    }
}
