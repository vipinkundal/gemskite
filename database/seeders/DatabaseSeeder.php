<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'first_name' => 'testing',
            'last_name' => 'testing',
            'phone' => '9900000000',
            'email' => 'testing@gmail.com',
            'email_verified_at' => Carbon::now()->toDateTimeString(),
            'password' => Hash::make('oneplus10t'),
        ]);
    }
}
