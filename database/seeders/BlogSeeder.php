<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $placeholders = [
            'https://placehold.co/800x600/1a1a2e/eee?text=Blog+1',
            'https://placehold.co/800x600/16213e/eee?text=Blog+2',
            'https://placehold.co/800x600/0f3460/eee?text=Blog+3',
            'https://placehold.co/800x600/533483/eee?text=Blog+4',
            'https://placehold.co/800x600/e94560/eee?text=Blog+5',
            'https://placehold.co/800x600/1a1a2e/eee?text=Blog+6',
            'https://placehold.co/800x600/16213e/eee?text=Blog+7',
            'https://placehold.co/800x600/0f3460/eee?text=Blog+8',
        ];

        $blogs = Blog::factory()->count(8)->create();

        foreach ($blogs as $index => $blog) {
            $url = $placeholders[$index % count($placeholders)];
            try {
                $blog->addMediaFromUrl($url)->toMediaCollection('image');
            } catch (\Exception $e) {
                // If addMediaFromUrl fails (e.g. no network), skip image
                report($e);
            }
        }
    }
}
