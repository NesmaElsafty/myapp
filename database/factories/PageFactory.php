<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Page>
 */
class PageFactory extends Factory
{
    protected $model = Page::class;

    private static function logicalPages(): array
    {
        return [
            [
                'title_en' => 'About Us',
                'title_ar' => 'من نحن',
                'content_en' => 'We are a company dedicated to delivering quality services and building lasting relationships with our clients. Our team works every day to exceed your expectations and support your growth.',
                'content_ar' => 'نحن شركة ملتزمة بتقديم خدمات عالية الجودة وبناء علاقات دائمة مع عملائنا. يعمل فريقنا كل يوم لتجاوز توقعاتك ودعم نموك.',
            ],
            [
                'title_en' => 'Privacy Policy',
                'title_ar' => 'سياسة الخصوصية',
                'content_en' => 'Your privacy is important to us. This policy outlines how we collect, use, store and protect your personal information. We are committed to transparency and compliance with applicable data protection laws.',
                'content_ar' => 'خصوصيتك مهمة لنا. توضح هذه السياسة كيفية جمعنا واستخدامنا وتخزيننا وحمايتنا لمعلوماتك الشخصية. نحن ملتزمون بالشفافية والامتثال لقوانين حماية البيانات المعمول بها.',
            ],
            [
                'title_en' => 'Terms of Service',
                'title_ar' => 'شروط الخدمة',
                'content_en' => 'By using our services, you agree to these terms. Please read them carefully. They cover your rights, obligations and the rules that govern the use of our platform and services.',
                'content_ar' => 'باستخدام خدماتنا، فإنك توافق على هذه الشروط. يرجى قراءتها بعناية. وهي تغطي حقوقك والتزاماتك والقواعد التي تحكم استخدام منصتنا وخدماتنا.',
            ],
            [
                'title_en' => 'Contact Us',
                'title_ar' => 'اتصل بنا',
                'content_en' => 'We are here to help. Reach out to our team for any questions, feedback or support. You can contact us by email, phone or through the form on this page. We aim to respond as soon as possible.',
                'content_ar' => 'نحن هنا لمساعدتك. تواصل مع فريقنا لأي استفسارات أو ملاحظات أو دعم. يمكنك الاتصال بنا عبر البريد الإلكتروني أو الهاتف أو عبر النموذج في هذه الصفحة. نسعى للرد في أقرب وقت ممكن.',
            ],
            [
                'title_en' => 'Our Team',
                'title_ar' => 'فريقنا',
                'content_en' => 'Meet the people behind our success. Our team brings together experience, creativity and a shared commitment to excellence. We work as one to deliver the best results for our clients.',
                'content_ar' => 'تعرف على الأشخاص وراء نجاحنا. يجمع فريقنا بين الخبرة والإبداع والالتزام المشترك بالتميز. نعمل كفريق واحد لتقديم أفضل النتائج لعملائنا.',
            ],
            [
                'title_en' => 'Frequently Asked Questions',
                'title_ar' => 'الأسئلة الشائعة',
                'content_en' => 'Find answers to the most common questions about our services, processes and policies. If you do not find what you need, do not hesitate to contact our support team.',
                'content_ar' => 'اعثر على إجابات للأسئلة الأكثر شيوعاً حول خدماتنا وعملياتنا وسياساتنا. إذا لم تجد ما تحتاجه، لا تتردد في التواصل مع فريق الدعم لدينا.',
            ],
        ];
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $pages = self::logicalPages();
        return $pages[array_rand($pages)];
    }
}
