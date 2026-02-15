<?php

namespace Database\Seeders;

use App\Models\Input;
use App\Models\Screen;
use Illuminate\Database\Seeder;

class InputSeeder extends Seeder
{
    /**
     * Logical form input definitions with English and Arabic.
     * Options: one value per option (same for en/ar). select/radio => { choices: [{ value, label_en, label_ar }] }; checkbox => { label_en, label_ar }.
     * Each screen gets a random subset of these inputs.
     */
    private function inputTemplates(): array
    {
        return [
            [
                'title_en' => 'Full Name',
                'title_ar' => 'الاسم الكامل',
                'placeholder_en' => 'Enter your full name',
                'placeholder_ar' => 'أدخل اسمك الكامل',
                'description_en' => 'As it appears on your ID',
                'description_ar' => 'كما يظهر في هويتك',
                'type' => 'text',
                'options' => null,
                'is_required' => true,
            ],
            [
                'title_en' => 'Email',
                'title_ar' => 'البريد الإلكتروني',
                'placeholder_en' => 'example@domain.com',
                'placeholder_ar' => 'example@domain.com',
                'description_en' => 'We will contact you at this email',
                'description_ar' => 'سنتواصل معك على هذا البريد',
                'type' => 'email',
                'options' => null,
                'is_required' => true,
            ],
            [
                'title_en' => 'Phone Number',
                'title_ar' => 'رقم الهاتف',
                'placeholder_en' => '05XXXXXXXX',
                'placeholder_ar' => '05XXXXXXXX',
                'description_en' => 'Mobile or landline',
                'description_ar' => 'جوال أو هاتف ثابت',
                'type' => 'phone',
                'options' => null,
                'is_required' => true,
            ],
            [
                'title_en' => 'Date of Birth',
                'title_ar' => 'تاريخ الميلاد',
                'placeholder_en' => null,
                'placeholder_ar' => null,
                'description_en' => 'Select your birth date',
                'description_ar' => 'اختر تاريخ ميلادك',
                'type' => 'date',
                'options' => null,
                'is_required' => true,
            ],
            [
                'title_en' => 'Gender',
                'title_ar' => 'الجنس',
                'placeholder_en' => null,
                'placeholder_ar' => null,
                'description_en' => 'Select your gender',
                'description_ar' => 'اختر جنسك',
                'type' => 'select',
                'options' => [
                    'choices' => [
                        ['value' => 'male', 'label_en' => 'Male', 'label_ar' => 'ذكر'],
                        ['value' => 'female', 'label_en' => 'Female', 'label_ar' => 'أنثى'],
                    ],
                ],
                'is_required' => true,
            ],
            [
                'title_en' => 'Preferred Contact',
                'title_ar' => 'طريقة التواصل المفضلة',
                'placeholder_en' => null,
                'placeholder_ar' => null,
                'description_en' => 'How should we contact you?',
                'description_ar' => 'كيف نتواصل معك؟',
                'type' => 'select',
                'options' => [
                    'choices' => [
                        ['value' => 'email', 'label_en' => 'Email', 'label_ar' => 'البريد الإلكتروني'],
                        ['value' => 'phone', 'label_en' => 'Phone', 'label_ar' => 'الهاتف'],
                        ['value' => 'whatsapp', 'label_en' => 'WhatsApp', 'label_ar' => 'واتساب'],
                    ],
                ],
                'is_required' => false,
            ],
            [
                'title_en' => 'Message',
                'title_ar' => 'الرسالة',
                'placeholder_en' => 'Write your message here...',
                'placeholder_ar' => 'اكتب رسالتك هنا...',
                'description_en' => 'Maximum 500 characters',
                'description_ar' => 'حد أقصى 500 حرف',
                'type' => 'textarea',
                'options' => null,
                'is_required' => true,
            ],
            [
                'title_en' => 'Address',
                'title_ar' => 'العنوان',
                'placeholder_en' => 'Street, city, postal code',
                'placeholder_ar' => 'الشارع، المدينة، الرمز البريدي',
                'description_en' => null,
                'description_ar' => null,
                'type' => 'text',
                'options' => null,
                'is_required' => false,
            ],
            [
                'title_en' => 'National ID',
                'title_ar' => 'رقم الهوية الوطنية',
                'placeholder_en' => '10 digits',
                'placeholder_ar' => '10 أرقام',
                'description_en' => 'Your national ID number',
                'description_ar' => 'رقم هويتك الوطنية',
                'type' => 'number',
                'options' => null,
                'is_required' => false,
            ],
            [
                'title_en' => 'Preferred Contact Time',
                'title_ar' => 'الوقت المفضل للتواصل',
                'placeholder_en' => null,
                'placeholder_ar' => null,
                'description_en' => 'When can we call you?',
                'description_ar' => 'متى يمكننا الاتصال بك؟',
                'type' => 'time',
                'options' => null,
                'is_required' => false,
            ],
            [
                'title_en' => 'Agree to terms',
                'title_ar' => 'الموافقة على الشروط',
                'placeholder_en' => null,
                'placeholder_ar' => null,
                'description_en' => 'I have read and accept the terms',
                'description_ar' => 'لقد قرأت وأوافق على الشروط',
                'type' => 'checkbox',
                'options' => [
                    'label_en' => 'I agree',
                    'label_ar' => 'أوافق',
                ],
                'is_required' => true,
            ],
            [
                'title_en' => 'Website',
                'title_ar' => 'الموقع الإلكتروني',
                'placeholder_en' => 'https://',
                'placeholder_ar' => 'https://',
                'description_en' => 'Optional',
                'description_ar' => 'اختياري',
                'type' => 'url',
                'options' => null,
                'is_required' => false,
            ],
            [
                'title_en' => 'Upload Document',
                'title_ar' => 'رفع المستند',
                'placeholder_en' => null,
                'placeholder_ar' => null,
                'description_en' => 'PDF or image, max 5MB',
                'description_ar' => 'PDF أو صورة، حد أقصى 5 ميجا',
                'type' => 'file',
                'options' => null,
                'is_required' => false,
            ],
        ];
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $screens = Screen::all();

        if ($screens->isEmpty()) {
            $this->command->warn('No screens found. Run ScreenSeeder first.');
            return;
        }

        $templates = $this->inputTemplates();

        foreach ($screens as $screen) {
            // Each screen gets 3 to 6 inputs, picked from templates without repeating
            $count = min(rand(3, 6), count($templates));
            $picked = array_rand(array_flip(array_keys($templates)), $count);
            $picked = is_array($picked) ? $picked : [$picked];

            foreach ($picked as $index) {
                $template = $templates[$index];
                Input::create([
                    'screen_id' => $screen->id,
                    'title_en' => $template['title_en'],
                    'title_ar' => $template['title_ar'],
                    'placeholder_en' => $template['placeholder_en'],
                    'placeholder_ar' => $template['placeholder_ar'],
                    'description_en' => $template['description_en'],
                    'description_ar' => $template['description_ar'],
                    'type' => $template['type'],
                    'options' => $template['options'],
                    'is_required' => $template['is_required'],
                ]);
            }
        }
    }
}
