<?php

namespace Database\Seeders;

use App\Models\Ad;
use Illuminate\Database\Seeder;

class AdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $placeholders = [
            'https://placehold.co/800x400/1a1a2e/eee?text=Ad+1',
            'https://placehold.co/800x400/16213e/eee?text=Ad+2',
            'https://placehold.co/800x400/0f3460/eee?text=Ad+3',
            'https://placehold.co/800x400/533483/eee?text=Ad+4',
            'https://placehold.co/800x400/e94560/eee?text=Ad+5',
        ];

        $ads = Ad::factory()->count(5)->create();

        foreach ($ads as $index => $ad) {
            $url = $placeholders[$index % count($placeholders)];
            try {
                $ad->addMediaFromUrl($url)->toMediaCollection('image');
            } catch (\Exception $e) {
                // If addMediaFromUrl fails (e.g. no network), skip image
                report($e);
            }
        }
    }
}
