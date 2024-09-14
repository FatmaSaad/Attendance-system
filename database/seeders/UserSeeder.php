<?php

namespace Database\Seeders;

use App\Models\CheckIn;
use App\Models\CheckOut;
use App\Models\User;
use Carbon\Carbon;
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
        ])->each(function ($user) {
            CheckIn::factory()->count(10)->create([
                'user_id' => $user->id,
                'created_at' => fake()->dateTimeThisYear(),
            ])->each(function ($checkIn) {
            CheckOut::factory()->count(1)->create([
                'check_in_id' => $checkIn->id,
                'created_at' => Carbon::parse($checkIn->created_at)->addHours(rand(1, 8))
            ]);
        
        });
    });
}
}


