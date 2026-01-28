<?php

namespace Database\Factories;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['reminder', 'alert', 'notification'];
        $targetTypes = ['user', 'individual', 'origin'];
        $statuses = ['sent', 'scheduled', 'unsent'];

        // Randomly select 1-3 target types
        $selectedTargets = fake()->randomElements($targetTypes, fake()->numberBetween(1, 3));

        return [
            'title_en' => fake()->sentence(),
            'title_ar' => fake()->sentence(),
            //content should be shorter
            'content_en' => fake()->sentence(10),
            'content_ar' => fake()->sentence(10),
            'type' => fake()->randomElement($types),
            'target_type' => $selectedTargets,
            'status' => fake()->randomElement($statuses),
        ];
    }

    /**
     * Indicate that the notification is a reminder.
     */
    public function reminder(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'reminder',
        ]);
    }

    /**
     * Indicate that the notification is an alert.
     */
    public function alert(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'alert',
        ]);
    }

    /**
     * Indicate that the notification is a notification.
     */
    public function notificationType(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'notification',
        ]);
    }

    /**
     * Indicate that the notification targets users.
     */
    public function forUsers(): static
    {
        return $this->state(fn (array $attributes) => [
            'target_type' => ['user'],
        ]);
    }

    /**
     * Indicate that the notification targets individuals.
     */
    public function forIndividuals(): static
    {
        return $this->state(fn (array $attributes) => [
            'target_type' => ['individual'],
        ]);
    }

    /**
     * Indicate that the notification targets origins.
     */
    public function forOrigins(): static
    {
        return $this->state(fn (array $attributes) => [
            'target_type' => ['origin'],
        ]);
    }

    /**
     * Indicate that the notification targets users and individuals.
     */
    public function forUsersAndIndividuals(): static
    {
        return $this->state(fn (array $attributes) => [
            'target_type' => ['user', 'individual'],
        ]);
    }

    /**
     * Indicate that the notification targets all types.
     */
    public function forAll(): static
    {
        return $this->state(fn (array $attributes) => [
            'target_type' => ['user', 'individual', 'origin'],
        ]);
    }

    /**
     * Indicate that the notification is sent.
     */
    public function sent(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'sent',
        ]);
    }

    /**
     * Indicate that the notification is scheduled.
     */
    public function scheduled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'scheduled',
        ]);
    }

    /**
     * Indicate that the notification is unsent.
     */
    public function unsent(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'unsent',
        ]);
    }
}
