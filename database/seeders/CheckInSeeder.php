<?php

namespace Database\Seeders;

use App\Models\CheckIn;
use App\Models\CheckOut;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CheckInSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CheckIn::factory()->count(10)->create()->each(function ($checkIn) {
            CheckOut::factory()->create([
                'check_in_id' => $checkIn->id,
                'created_at' => Carbon::parse($checkIn->created_at)->addHours(rand(1, 8))
            ]);

        });
    }
}
