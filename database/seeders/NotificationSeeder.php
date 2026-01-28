<?php

namespace Database\Seeders;

use App\Models\Notification;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create reminders
        Notification::factory()->count(5)->reminder()->forUsers()->sent()->create();
        Notification::factory()->count(3)->reminder()->forIndividuals()->sent()->create();
        Notification::factory()->count(2)->reminder()->forOrigins()->scheduled()->create();
        Notification::factory()->count(2)->reminder()->forUsersAndIndividuals()->sent()->create();
        Notification::factory()->count(1)->reminder()->forAll()->scheduled()->create();

        // Create alerts
        Notification::factory()->count(4)->alert()->forUsers()->sent()->create();
        Notification::factory()->count(3)->alert()->forIndividuals()->sent()->create();
        Notification::factory()->count(3)->alert()->forOrigins()->unsent()->create();
        Notification::factory()->count(2)->alert()->forUsersAndIndividuals()->sent()->create();
        Notification::factory()->count(1)->alert()->forAll()->unsent()->create();

        // Create notifications
        Notification::factory()->count(5)->notificationType()->forUsers()->sent()->create();
        Notification::factory()->count(4)->notificationType()->forIndividuals()->scheduled()->create();
        Notification::factory()->count(3)->notificationType()->forOrigins()->sent()->create();
        Notification::factory()->count(2)->notificationType()->forUsersAndIndividuals()->sent()->create();
        Notification::factory()->count(1)->notificationType()->forAll()->scheduled()->create();
    }
}
