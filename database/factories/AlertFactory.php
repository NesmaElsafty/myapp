<?php

namespace Database\Factories;

use App\Models\Alert;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alert>
 */
class AlertFactory extends Factory
{
    protected $model = Alert::class;

    private static function logicalAlerts(): array
    {
        return [
            [
                'title_en' => 'Welcome to our platform',
                'title_ar' => 'مرحباً بك في منصتنا',
                'content_en' => 'Thank you for joining us. We are glad to have you. Explore our services and do not hesitate to contact us if you need any help.',
                'content_ar' => 'شكراً لانضمامك إلينا. يسعدنا وجودك معنا. تصفح خدماتنا ولا تتردد في التواصل معنا إذا احتجت أي مساعدة.',
            ],
            [
                'title_en' => 'Your account has been verified',
                'title_ar' => 'تم التحقق من حسابك',
                'content_en' => 'Your email and account have been verified successfully. You now have full access to all features.',
                'content_ar' => 'تم التحقق من بريدك الإلكتروني وحسابك بنجاح. لديك الآن وصول كامل لجميع الميزات.',
            ],
            [
                'title_en' => 'Password changed successfully',
                'title_ar' => 'تم تغيير كلمة المرور بنجاح',
                'content_en' => 'Your password was updated. If you did not make this change, please contact support immediately.',
                'content_ar' => 'تم تحديث كلمة المرور الخاصة بك. إذا لم تقم بهذا التغيير، يرجى التواصل مع الدعم فوراً.',
            ],
            [
                'title_en' => 'New message received',
                'title_ar' => 'تم استلام رسالة جديدة',
                'content_en' => 'You have a new message in your inbox. Log in to view and reply.',
                'content_ar' => 'لديك رسالة جديدة في صندوق الوارد. سجّل الدخول لعرضها والرد عليها.',
            ],
            [
                'title_en' => 'Your request has been processed',
                'title_ar' => 'تم معالجة طلبك',
                'content_en' => 'Your request has been completed successfully. You can view the details in your account.',
                'content_ar' => 'تم إكمال طلبك بنجاح. يمكنك عرض التفاصيل في حسابك.',
            ],
            [
                'title_en' => 'Reminder: pending action',
                'title_ar' => 'تذكير: إجراء معلق',
                'content_en' => 'You have a pending action that requires your attention. Please complete it at your earliest convenience.',
                'content_ar' => 'لديك إجراء معلق يحتاج إلى انتباهك. يرجى إكماله في أقرب فرصة.',
            ],
            [
                'title_en' => 'Special offer for you',
                'title_ar' => 'عرض خاص لك',
                'content_en' => 'We have a special offer just for you. Check your account or our website to see the details and valid period.',
                'content_ar' => 'لدينا عرض خاص لك فقط. تحقق من حسابك أو موقعنا لمعرفة التفاصيل والفترة الصالحة.',
            ],
            [
                'title_en' => 'Scheduled maintenance',
                'title_ar' => 'صيانة مجدولة',
                'content_en' => 'Our system will undergo scheduled maintenance. Services may be briefly unavailable. We apologize for any inconvenience.',
                'content_ar' => 'ستخضع منصتنا لصيانة مجدولة. قد تكون الخدمات غير متاحة لفترة قصيرة. نعتذر عن أي إزعاج.',
            ],
            [
                'title_en' => 'Profile updated successfully',
                'title_ar' => 'تم تحديث الملف الشخصي بنجاح',
                'content_en' => 'Your profile information has been saved. You can update it again anytime from your account settings.',
                'content_ar' => 'تم حفظ معلومات ملفك الشخصي. يمكنك تحديثها مرة أخرى في أي وقت من إعدادات حسابك.',
            ],
            [
                'title_en' => 'Payment received',
                'title_ar' => 'تم استلام الدفع',
                'content_en' => 'We have received your payment. Thank you. Your subscription or order is now active.',
                'content_ar' => 'تم استلام دفعتك. شكراً لك. اشتراكك أو طلبك مفعّل الآن.',
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
        $alerts = self::logicalAlerts();
        $item = $alerts[array_rand($alerts)];

        return [
            'user_id' => User::factory(),
            'title_en' => $item['title_en'],
            'title_ar' => $item['title_ar'],
            'content_en' => $item['content_en'],
            'content_ar' => $item['content_ar'],
            'is_read' => fake()->boolean(30),
        ];
    }

    /**
     * Indicate that the alert is read.
     */
    public function read(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_read' => true,
        ]);
    }

    /**
     * Indicate that the alert is unread.
     */
    public function unread(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_read' => false,
        ]);
    }

    /**
     * Indicate that the alert belongs to a specific user.
     */
    public function forUser(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $user->id,
        ]);
    }
}
