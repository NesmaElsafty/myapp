<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Screen;
use Database\Seeders\Concerns\SeedsInputScreens;
use Illuminate\Database\Seeder;

class InputFurnitureAccessoriesSeeder extends Seeder
{
    use SeedsInputScreens;

    public function run(): void
    {
        if (!Category::find(4)) {
            return;
        }

        $this->registerInputCreatingHook();

        $screen1 = Screen::where('category_id', 4)->where('name_en', 'Basic Data for Furniture and Accessories')->first();
        $this->seedInputsForScreen($screen1, $this->inputsForCategoryFourScreen1());
    }

    private function inputsForCategoryFourScreen1(): array
    {
        return [
            [
                'title_en' => 'Furniture Type', 'title_ar' => 'نوع الاثاث',
                'placeholder_en' => 'Select furniture type', 'placeholder_ar' => 'حدد نوع الاثاث',
                'description_en' => null, 'description_ar' => null,
                'name' => 'furniture_type',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'bed', 'label_en' => 'Bed', 'label_ar' => 'سرير'],
                        ['value' => 'table', 'label_en' => 'Table', 'label_ar' => 'طاولة'],
                        ['value' => 'sofa', 'label_en' => 'Sofa', 'label_ar' => 'كنب'],
                        ['value' => 'desk', 'label_en' => 'Desk', 'label_ar' => 'مكتب'],
                        ['value' => 'wardrobe', 'label_en' => 'Wardrobe', 'label_ar' => 'دولاب'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Style', 'title_ar' => 'النمط',
                'placeholder_en' => 'Select style', 'placeholder_ar' => 'حدد النمط',
                'description_en' => null, 'description_ar' => null,
                'name' => 'style',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'modern', 'label_en' => 'Modern', 'label_ar' => 'مودرن'],
                        ['value' => 'classic', 'label_en' => 'Classic', 'label_ar' => 'كلاسيك'],
                        ['value' => 'authentic', 'label_en' => 'Authentic', 'label_ar' => 'وافي'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Color', 'title_ar' => 'اللون',
                'placeholder_en' => 'Select color', 'placeholder_ar' => 'حدد اللون',
                'description_en' => null, 'description_ar' => null,
                'name' => 'color',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'white', 'label_en' => 'White', 'label_ar' => 'أبيض'],
                        ['value' => 'black', 'label_en' => 'Black', 'label_ar' => 'أسود'],
                        ['value' => 'brown', 'label_en' => 'Brown', 'label_ar' => 'بني'],
                        ['value' => 'grey', 'label_en' => 'Grey', 'label_ar' => 'رمادي'],
                        ['value' => 'beige', 'label_en' => 'Beige', 'label_ar' => 'بيج'],
                    ],
                ], 'is_required' => true,
            ],
            [
                'title_en' => 'Material', 'title_ar' => 'الخامة',
                'placeholder_en' => 'Select material', 'placeholder_ar' => 'حدد الخامة',
                'description_en' => null, 'description_ar' => null,
                'name' => 'material',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'glass', 'label_en' => 'Glass', 'label_ar' => 'زجاج'],
                        ['value' => 'plastic', 'label_en' => 'Plastic', 'label_ar' => 'بلاستيك'],
                        ['value' => 'fabric', 'label_en' => 'Fabric', 'label_ar' => 'قماش'],
                        ['value' => 'leather', 'label_en' => 'Leather', 'label_ar' => 'جلد'],
                        ['value' => 'wood', 'label_en' => 'Wood', 'label_ar' => 'خشب'],
                        ['value' => 'marble', 'label_en' => 'Marble', 'label_ar' => 'رخام'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Number of Pieces', 'title_ar' => 'عدد القطع',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => null, 'description_ar' => null,
                'name' => 'number_of_pieces',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'number', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Dimensions (m²)', 'title_ar' => 'الابعاد (م²)',
                'placeholder_en' => 'Enter dimensions (m²)', 'placeholder_ar' => 'ادخل الابعاد (م²)',
                'description_en' => null, 'description_ar' => null,
                'name' => 'dimensions_m2',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'text', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Brand', 'title_ar' => 'العلامة التجارية',
                'placeholder_en' => 'Select brand', 'placeholder_ar' => 'حدد العلامة التجارية',
                'description_en' => null, 'description_ar' => null,
                'name' => 'brand',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'text', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Condition', 'title_ar' => 'الحالة',
                'placeholder_en' => 'Select condition', 'placeholder_ar' => 'حدد الحالة',
                'description_en' => null, 'description_ar' => null,
                'name' => 'condition',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'radio', 'options' => [
                    'choices' => [
                        ['value' => 'new', 'label_en' => 'New', 'label_ar' => 'جديد'],
                        ['value' => 'used', 'label_en' => 'Used', 'label_ar' => 'مستعمل'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Warranty Period', 'title_ar' => 'مدة الضمان',
                'placeholder_en' => 'Enter warranty period', 'placeholder_ar' => 'أدخل مدة الضمان',
                'description_en' => null, 'description_ar' => null,
                'name' => 'warranty_period',
                'validation_rules' => ['nullable', 'numeric'],
                'type' => 'text', 'options' => null, 'is_required' => false,
            ],
            [
                'title_en' => 'Furniture Photos & Videos', 'title_ar' => 'صور و فيديو الاثاث',
                'placeholder_en' => null, 'placeholder_ar' => null,
                'description_en' => 'At least 3 photos must be added to display the furniture more clearly.', 'description_ar' => 'يجب إضافة ٣ صور على الأقل لعرض الأثاث بشكل أوضح',
                'name' => 'furniture_photos_videos',
                'validation_rules' => ['nullable', 'array'],
                'type' => 'image', 'options' => null, 'is_required' => true,
            ],
        ];
    }

    /**
     * Logical form input definitions with English and Arabic.
     * Options: one value per option (same for en/ar). select/radio => { choices: [{ value, label_en, label_ar }] }; checkbox => { label_en, label_ar }.
     * Each screen gets a random subset of these inputs.
     */

}
