<?php

namespace Database\Seeders;

use App\Models\SocialMedia;
use Illuminate\Database\Seeder;

class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $socialMedia = [
            [
                'platform' => 'Facebook',
                'url' => 'https://www.facebook.com/example',
            ],
            [
                'platform' => 'Twitter',
                'url' => 'https://www.twitter.com/example',
            ],
            [
                'platform' => 'Instagram',
                'url' => 'https://www.instagram.com/example',
            ],
            [
                'platform' => 'LinkedIn',
                'url' => 'https://www.linkedin.com/company/example',
            ],
            [
                'platform' => 'YouTube',
                'url' => 'https://www.youtube.com/@example',
            ],
        ];

        foreach ($socialMedia as $media) {
            SocialMedia::create($media);
        }
    }
}
