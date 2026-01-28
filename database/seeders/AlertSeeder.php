<?php

namespace Database\Seeders;

use App\Models\Alert;
use App\Models\User;
use Illuminate\Database\Seeder;

class AlertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some users to assign alerts to
        $users = User::take(20)->get();

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please seed users first.');
            return;
        }

        // Create read alerts for various users
        foreach ($users->take(10) as $user) {
            Alert::factory()
                ->count(3)
                ->forUser($user)
                ->read()
                ->create();
        }

        // Create unread alerts for various users
        foreach ($users->skip(10)->take(10) as $user) {
            Alert::factory()
                ->count(2)
                ->forUser($user)
                ->unread()
                ->create();
        }

        // Create mixed read/unread alerts for first user
        if ($users->isNotEmpty()) {
            Alert::factory()
                ->count(5)
                ->forUser($users->first())
                ->create(); // Random read/unread status
        }
    }
}
