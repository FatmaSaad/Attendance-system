<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::factory()->create([
            'user_id' => '123',
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '123456',
        ]);
    }
}


