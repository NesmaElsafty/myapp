<?php

namespace Database\Seeders;

use App\Models\Input;
use App\Models\Screen;
use Database\Seeders\Concerns\SeedsInputScreens;
use Illuminate\Database\Seeder;

class InputOtherCategoriesSeeder extends Seeder
{
    use SeedsInputScreens;

    public function run(): void
    {
        $this->registerInputCreatingHook();

        $screens = Screen::all();
        if ($screens->isEmpty()) {
            return;
        }

        $templates = $this->inputTemplates();
        $excludeScreenIds = Screen::whereIn('category_id', [1, 2, 3, 4, 5, 6, 7, 8,9,10])->pluck('id')->all();

        foreach ($screens as $screen) {
            if (in_array($screen->id, $excludeScreenIds, true)) {
                continue;
            }

            $count = min(rand(3, 6), count($templates));
            $picked = array_rand(array_flip(array_keys($templates)), $count);
            $picked = is_array($picked) ? $picked : [$picked];

            foreach ($picked as $index) {
                $template = $templates[$index];
                Input::create([
                    'screen_id' => $screen->id,
                    'name' => $template['name'],
                    'key' => $template['name'],
                    'validation_rules' => $template['validation_rules'],
                    'title_en' => $template['title_en'],
                    'title_ar' => $template['title_ar'],
                    'placeholder_en' => $template['placeholder_en'],
                    'placeholder_ar' => $template['placeholder_ar'],
                    'description_en' => $template['description_en'],
                    'description_ar' => $template['description_ar'],
                    'type' => $template['type'],
                    'options' => $template['options'],
                    'is_required' => $template['is_required'],
                    'is_active' => true,
                ]);
            }
        }
    }

    private function inputTemplates(): array
    {
        return [
            [
                'name' => 'Device',
                'validation_rules' => ['nullable', 'string'],
                'title_en' => 'Device Name',
                'title_ar' => 'الاسم الكامل',
                'placeholder_en' => 'Enter device name',
                'placeholder_ar' => 'أدخل اسم الجهاز',
                'description_en' => 'Device name',
                'description_ar' => 'أدخل اسم الجهاز',
                'type' => 'readOnly_text',
                'options' => null,
                'is_required' => true,
            ],
            [
                'name' => 'Device Brand',
                'validation_rules' => ['nullable', 'string'],
                'title_en' => 'Device Brand',
                'title_ar' => 'الماركة',
                'placeholder_en' => 'Enter device brand',
                'placeholder_ar' => 'أدخل الماركة',
                'description_en' => 'Device brand',
                'description_ar' => 'الماركة',
                'type' => 'radio',
                'options' => [
                    'choices' => [
                        ['value' => 'iphone', 'label_en' => 'iPhone', 'label_ar' => 'ايفون / iPhone'],
                        ['value' => 'samsung', 'label_en' => 'Samsung', 'label_ar' => 'سامسونج / Samsung'],
                        ['value' => 'oppo', 'label_en' => 'Oppo', 'label_ar' => 'اوبو / Oppo'],
                        ['value' => 'realme', 'label_en' => 'Realme', 'label_ar' => 'ريلمي / Realme'],
                        ['value' => 'xiaomi', 'label_en' => 'Xiaomi', 'label_ar' => 'شاومي / Xiaomi'],
                        ['value' => 'huawei', 'label_en' => 'Huawei', 'label_ar' => 'هواوي / Huawei'],
                    ],
                ],
                'is_required' => true,
            ],
            [
                'name' => 'Device Model',
                'validation_rules' => ['nullable', 'string'],
                'title_en' => 'Device Model',
                'title_ar' => 'نوع الجهاز',
                'placeholder_en' => 'Enter device model',
                'placeholder_ar' => 'أدخل نوع الجهاز',
                'description_en' => 'Device model type',
                'description_ar' => 'الموديل',
                'type' => 'radio',
                'options' => [
                    'choices' => [
                        ['value' => 'iphone', 'label_en' => 'iPhone', 'label_ar' => 'ايفون / iPhone'],
                        ['value' => 'samsung', 'label_en' => 'Samsung', 'label_ar' => 'سامسونج / Samsung'],
                        ['value' => 'oppo', 'label_en' => 'Oppo', 'label_ar' => 'اوبو / Oppo'],
                        ['value' => 'realme', 'label_en' => 'Realme', 'label_ar' => 'ريلمي / Realme'],
                        ['value' => 'xiaomi', 'label_en' => 'Xiaomi', 'label_ar' => 'شاومي / Xiaomi'],
                        ['value' => 'huawei', 'label_en' => 'Huawei', 'label_ar' => 'هواوي / Huawei'],
                    ],
                ],
                'is_required' => true,
            ],
        ];
    }

    /**
     * Run the database seeds.
     */

}
