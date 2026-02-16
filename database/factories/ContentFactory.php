<?php

namespace Database\Factories;

use App\Models\Content;
use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Content>
 */
class ContentFactory extends Factory
{
    protected $model = Content::class;

    private static function cardData(): array
    {
        $items = [
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
            [
                'title_en' => 'Quality Assurance',
                'title_ar' => 'ضمان الجودة',
                'content_en' => 'We follow strict quality standards to ensure the best outcomes for every project.',
                'content_ar' => 'نلتزم بمعايير جودة صارمة لضمان أفضل النتائج لكل مشروع.',
            ],
            [
                'title_en' => 'Customer Support',
                'title_ar' => 'دعم العملاء',
                'content_en' => 'Our support team is available around the clock to assist you with any inquiry.',
                'content_ar' => 'فريق الدعم لدينا متاح على مدار الساعة لمساعدتك في أي استفسار.',
            ],
        ];
        return $items[array_rand($items)];
    }

    private static function listData(): array
    {
        $items = [
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
            [
                'title_en' => 'Key Benefits',
                'title_ar' => 'أبرز المميزات',
                'content_en' => "• Save time and effort\n• Reliable and secure solutions\n• Scalable to your growth\n• Clear and honest communication",
                'content_ar' => "• توفير الوقت والجهد\n• حلول موثوقة وآمنة\n• قابلة للتوسع مع نموك\n• تواصل واضح وصريح",
            ],
        ];
        return $items[array_rand($items)];
    }

    private static function imgTextData(): array
    {
        $items = [
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
            [
                'title_en' => 'Our Approach',
                'title_ar' => 'نهجنا',
                'content_en' => 'We combine experience with innovation to deliver solutions that meet your expectations and help you achieve your goals effectively.',
                'content_ar' => 'نجمع بين الخبرة والابتكار لتقديم حلول تلبي توقعاتك وتساعدك على تحقيق أهدافك بفعالية.',
            ],
        ];
        return $items[array_rand($items)];
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = [Content::TYPE_IMG_TEXT, Content::TYPE_CARD, Content::TYPE_LIST];
        $type = fake()->randomElement($types);

        $data = match ($type) {
            Content::TYPE_CARD => self::cardData(),
            Content::TYPE_LIST => self::listData(),
            default => self::imgTextData(),
        };

        return [
            'page_id' => Page::factory(),
            'type' => $type,
            'title_en' => $data['title_en'],
            'title_ar' => $data['title_ar'],
            'content_en' => $data['content_en'],
            'content_ar' => $data['content_ar'],
        ];
    }

    public function imgText(): static
    {
        $data = self::imgTextData();
        return $this->state(fn (array $attributes) => [
            'type' => Content::TYPE_IMG_TEXT,
            'title_en' => $data['title_en'],
            'title_ar' => $data['title_ar'],
            'content_en' => $data['content_en'],
            'content_ar' => $data['content_ar'],
        ]);
    }

    public function card(): static
    {
        $data = self::cardData();
        return $this->state(fn (array $attributes) => [
            'type' => Content::TYPE_CARD,
            'title_en' => $data['title_en'],
            'title_ar' => $data['title_ar'],
            'content_en' => $data['content_en'],
            'content_ar' => $data['content_ar'],
        ]);
    }

    public function list(): static
    {
        $data = self::listData();
        return $this->state(fn (array $attributes) => [
            'type' => Content::TYPE_LIST,
            'title_en' => $data['title_en'],
            'title_ar' => $data['title_ar'],
            'content_en' => $data['content_en'],
            'content_ar' => $data['content_ar'],
        ]);
    }
}
