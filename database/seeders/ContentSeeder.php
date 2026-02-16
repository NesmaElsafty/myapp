<?php

namespace Database\Seeders;

use App\Models\Content;
use App\Models\Page;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Logical content blocks: type => [ title_en, title_ar, content_en, content_ar ]
     */
    private function logicalContents(): array
    {
        return [
            'card' => [
                [
                    'title_en' => 'Our Vision',
                    'title_ar' => 'رؤيتنا',
                    'content_en' => 'To be the leading provider of quality services and innovative solutions in our region.',
                    'content_ar' => 'أن نكون الرائد في تقديم خدمات عالية الجودة وحلول مبتكرة في منطقتنا.',
                ],
                [
                    'title_en' => 'Our Mission',
                    'title_ar' => 'مهمتنا',
                    'content_en' => 'We deliver excellence through dedication, integrity, and a constant focus on our clients\' needs.',
                    'content_ar' => 'نحن نقدم التميز من خلال الالتزام والنزاهة والتركيز الدائم على احتياجات عملائنا.',
                ],
                [
                    'title_en' => 'Our Values',
                    'title_ar' => 'قيمنا',
                    'content_en' => 'Integrity, transparency, innovation and customer first guide everything we do.',
                    'content_ar' => 'النزاهة والشفافية والابتكار ووضع العميل أولاً توجه كل ما نقوم به.',
                ],
            ],
            'list' => [
                [
                    'title_en' => 'Why Choose Us',
                    'title_ar' => 'لماذا تختارنا',
                    'content_en' => "• Years of experience in the industry\n• Dedicated professional team\n• Competitive and transparent pricing\n• Ongoing support after delivery",
                    'content_ar' => "• سنوات من الخبرة في المجال\n• فريق عمل محترف ومتفانٍ\n• أسعار منافسة وشفافة\n• دعم مستمر بعد التسليم",
                ],
                [
                    'title_en' => 'Our Services',
                    'title_ar' => 'خدماتنا',
                    'content_en' => "• Consultation and planning\n• Implementation and follow-up\n• Training and development\n• Technical support",
                    'content_ar' => "• الاستشارة والتخطيط\n• التنفيذ والمتابعة\n• التدريب والتطوير\n• الدعم الفني",
                ],
            ],
            'img_text' => [
                [
                    'title_en' => 'Who We Are',
                    'title_ar' => 'من نحن',
                    'content_en' => 'We are a team of experts committed to providing outstanding services. Our story began with a simple goal: to make a positive impact in everything we do.',
                    'content_ar' => 'نحن فريق من الخبراء ملتزمون بتقديم خدمات متميزة. بدأت قصتنا بهدف بسيط: إحداث تأثير إيجابي في كل ما نقوم به.',
                ],
                [
                    'title_en' => 'Our Journey',
                    'title_ar' => 'رحلتنا',
                    'content_en' => 'From a small start to a growing organization, we have built lasting relationships with our clients and partners based on trust and results.',
                    'content_ar' => 'من بداية متواضعة إلى منظمة نامية، بنينا علاقات دائمة مع عملائنا وشركائنا قائمة على الثقة والنتائج.',
                ],
            ],
        ];
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $placeholders = [
            'https://placehold.co/600x400/1a1a2e/eee?text=Content+1',
            'https://placehold.co/600x400/16213e/eee?text=Content+2',
            'https://placehold.co/600x400/0f3460/eee?text=Content+3',
            'https://placehold.co/600x400/533483/eee?text=Content+4',
            'https://placehold.co/600x400/e94560/eee?text=Content+5',
        ];

        $pages = Page::all();
        if ($pages->isEmpty()) {
            return;
        }

        $blocks = $this->logicalContents();

        foreach ($pages as $page) {
            foreach ($blocks['card'] as $item) {
                Content::create([
                    'page_id' => $page->id,
                    'type' => 'card',
                    'title_en' => $item['title_en'],
                    'title_ar' => $item['title_ar'],
                    'content_en' => $item['content_en'],
                    'content_ar' => $item['content_ar'],
                ]);
            }
            foreach ($blocks['list'] as $item) {
                Content::create([
                    'page_id' => $page->id,
                    'type' => 'list',
                    'title_en' => $item['title_en'],
                    'title_ar' => $item['title_ar'],
                    'content_en' => $item['content_en'],
                    'content_ar' => $item['content_ar'],
                ]);
            }
            $imgIndex = 0;
            foreach ($blocks['img_text'] as $item) {
                $content = Content::create([
                    'page_id' => $page->id,
                    'type' => 'img_text',
                    'title_en' => $item['title_en'],
                    'title_ar' => $item['title_ar'],
                    'content_en' => $item['content_en'],
                    'content_ar' => $item['content_ar'],
                ]);
                $url = $placeholders[$imgIndex % count($placeholders)];
                try {
                    $content->addMediaFromUrl($url)->toMediaCollection('image');
                } catch (\Exception $e) {
                    report($e);
                }
                $imgIndex++;
            }
        }
    }
}
