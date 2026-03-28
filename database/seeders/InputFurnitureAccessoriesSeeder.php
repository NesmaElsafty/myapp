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

    /**
     * @return list<array{value: string, label_en: string, label_ar: string}>
     */
    private function furnitureBrandChoices(): array
    {
        return [
            ['value' => 'ikea', 'label_en' => 'IKEA', 'label_ar' => 'إيكيا'],
            ['value' => 'home_centre', 'label_en' => 'Home Centre', 'label_ar' => 'هوم سنتر'],
            ['value' => 'pan_emirates', 'label_en' => 'Pan Emirates', 'label_ar' => 'بان إمارات'],
            ['value' => 'danube_home', 'label_en' => 'Danube Home', 'label_ar' => 'دانوب هوم'],
            ['value' => 'marina_home', 'label_en' => 'Marina Home', 'label_ar' => 'مارينا هوم'],
            ['value' => 'home_box', 'label_en' => 'Home Box', 'label_ar' => 'هوم بوكس'],
            ['value' => 'home_r_us', 'label_en' => 'Home R Us', 'label_ar' => 'هوم آر آس'],
            ['value' => '2xl_home', 'label_en' => '2XL Home', 'label_ar' => 'تو إكس إل هوم'],
            ['value' => 'pottery_barn', 'label_en' => 'Pottery Barn', 'label_ar' => 'بوتري بارن'],
            ['value' => 'pottery_barn_kids', 'label_en' => 'Pottery Barn Kids', 'label_ar' => 'بوتري بارن كيدز'],
            ['value' => 'west_elm', 'label_en' => 'West Elm', 'label_ar' => 'وست إلم'],
            ['value' => 'crate_and_barrel', 'label_en' => 'Crate & Barrel', 'label_ar' => 'كريت آند باريل'],
            ['value' => 'cb2', 'label_en' => 'CB2', 'label_ar' => 'سي بي 2'],
            ['value' => 'wayfair', 'label_en' => 'Wayfair', 'label_ar' => 'ويفير'],
            ['value' => 'article', 'label_en' => 'Article', 'label_ar' => 'أرتيكل'],
            ['value' => 'structube', 'label_en' => 'Structube', 'label_ar' => 'ستركتيوب'],
            ['value' => 'castlery', 'label_en' => 'Castlery', 'label_ar' => 'كاستلري'],
            ['value' => 'ashley_furniture', 'label_en' => 'Ashley Furniture', 'label_ar' => 'أشلي للأثاث'],
            ['value' => 'ethan_allen', 'label_en' => 'Ethan Allen', 'label_ar' => 'إيثان ألين'],
            ['value' => 'la_z_boy', 'label_en' => 'La-Z-Boy', 'label_ar' => 'لازي بوي'],
            ['value' => 'rooms_to_go', 'label_en' => 'Rooms To Go', 'label_ar' => 'رومز تو غو'],
            ['value' => 'restoration_hardware', 'label_en' => 'RH (Restoration Hardware)', 'label_ar' => 'آر إتش'],
            ['value' => 'arhaus', 'label_en' => 'Arhaus', 'label_ar' => 'أرهاوس'],
            ['value' => 'bernhardt', 'label_en' => 'Bernhardt', 'label_ar' => 'بيرنهاردت'],
            ['value' => 'hooker_furniture', 'label_en' => 'Hooker Furniture', 'label_ar' => 'هوكر للأثاث'],
            ['value' => 'lexington', 'label_en' => 'Lexington', 'label_ar' => 'ليكسينغتون'],
            ['value' => 'herman_miller', 'label_en' => 'Herman Miller', 'label_ar' => 'هيرمان ميلر'],
            ['value' => 'knoll', 'label_en' => 'Knoll', 'label_ar' => 'نول'],
            ['value' => 'vitra', 'label_en' => 'Vitra', 'label_ar' => 'فيترا'],
            ['value' => 'kartell', 'label_en' => 'Kartell', 'label_ar' => 'كارتيل'],
            ['value' => 'natuzzi', 'label_en' => 'Natuzzi', 'label_ar' => 'ناتوزي'],
            ['value' => 'natuzzi_editions', 'label_en' => 'Natuzzi Editions', 'label_ar' => 'ناتوزي إديشنز'],
            ['value' => 'poliform', 'label_en' => 'Poliform', 'label_ar' => 'بوليفورم'],
            ['value' => 'roche_bobois', 'label_en' => 'Roche Bobois', 'label_ar' => 'روش بوبوا'],
            ['value' => 'minotti', 'label_en' => 'Minotti', 'label_ar' => 'مينوتي'],
            ['value' => 'flexform', 'label_en' => 'Flexform', 'label_ar' => 'فليكسفورم'],
            ['value' => 'boconcept', 'label_en' => 'BoConcept', 'label_ar' => 'بوكونسيبت'],
            ['value' => 'stressless', 'label_en' => 'Stressless (Ekornes)', 'label_ar' => 'ستريسلس'],
            ['value' => 'hulsta', 'label_en' => 'Hülsta', 'label_ar' => 'هولستا'],
            ['value' => 'rolf_benz', 'label_en' => 'Rolf Benz', 'label_ar' => 'رولف بنز'],
            ['value' => 'muji', 'label_en' => 'MUJI', 'label_ar' => 'موجي'],
            ['value' => 'habitat', 'label_en' => 'Habitat', 'label_ar' => 'هابيتات'],
            ['value' => 'dfs', 'label_en' => 'DFS', 'label_ar' => 'دي إف إس'],
            ['value' => 'john_lewis', 'label_en' => 'John Lewis & Partners', 'label_ar' => 'جون لويس'],
            ['value' => 'local_handmade', 'label_en' => 'Local / handmade', 'label_ar' => 'محلي / صناعة يدوية'],
            ['value' => 'other', 'label_en' => 'Other', 'label_ar' => 'أخرى'],
        ];
    }

    private function inputsForCategoryFourScreen1(): array
    {
        $furnitureBrandChoices = $this->furnitureBrandChoices();

        return [
            [
                'title_en' => 'Furniture Type', 'title_ar' => 'نوع الاثاث',
                'placeholder_en' => 'Select furniture type', 'placeholder_ar' => 'حدد نوع الاثاث',
                'description_en' => null, 'description_ar' => null,
                'name' => 'furniture_type',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'select', 'options' => [
                    'choices' => [
                        ['value' => 'sofa', 'label_en' => 'Sofa', 'label_ar' => 'كنب'],
                        ['value' => 'chair', 'label_en' => 'Chair', 'label_ar' => 'كرسي'],
                        ['value' => 'table', 'label_en' => 'Table', 'label_ar' => 'طاولة'],
                        ['value' => 'dining_table', 'label_en' => 'Dining table', 'label_ar' => 'طاولة طعام'],
                        ['value' => 'equipment', 'label_en' => 'Equipment / supplies', 'label_ar' => 'تجهيزات'],
                        ['value' => 'desk', 'label_en' => 'Desk', 'label_ar' => 'مكتب'],
                        ['value' => 'bed', 'label_en' => 'Bed', 'label_ar' => 'سرير'],
                        ['value' => 'bedroom_wardrobe', 'label_en' => 'Bedroom wardrobe', 'label_ar' => 'دولاب غرفة نوم'],
                        ['value' => 'kitchen_cabinet', 'label_en' => 'Kitchen cabinet', 'label_ar' => 'دولاب مطبخ'],
                        ['value' => 'cabinet', 'label_en' => 'Cabinet / closet', 'label_ar' => 'خزانة'],
                        ['value' => 'curtain', 'label_en' => 'Curtain', 'label_ar' => 'ستارة'],
                        ['value' => 'mirror', 'label_en' => 'Mirror', 'label_ar' => 'مراية'],
                        ['value' => 'carpet', 'label_en' => 'Carpet / rugs', 'label_ar' => 'سجاد'],
                        ['value' => 'bedspread', 'label_en' => 'Bedspread / cover', 'label_ar' => 'مفرش'],
                        ['value' => 'pillows', 'label_en' => 'Pillows', 'label_ar' => 'مخدات'],
                        ['value' => 'cooking_utensils', 'label_en' => 'Cooking utensils', 'label_ar' => 'أواني طبخ'],
                        ['value' => 'garden_equipment', 'label_en' => 'Garden equipment', 'label_ar' => 'تجهيزات حدائق'],
                        ['value' => 'plastic_utensils', 'label_en' => 'Plastic utensils', 'label_ar' => 'أدوات بلاستيكية'],
                        ['value' => 'tissues', 'label_en' => 'Tissues / napkins', 'label_ar' => 'مناديل'],
                        ['value' => 'paper_utensils', 'label_en' => 'Paper products', 'label_ar' => 'أدوات ورقية'],
                        ['value' => 'collectibles', 'label_en' => 'Collectibles / décor', 'label_ar' => 'تحف'],
                        ['value' => 'paintings', 'label_en' => 'Paintings / frames', 'label_ar' => 'لوحات'],
                        ['value' => 'other', 'label_en' => 'Other', 'label_ar' => 'أخرى'],
                        ['value' => 'shelf', 'label_en' => 'Shelf', 'label_ar' => 'رف'],
                        ['value' => 'artificial_trees', 'label_en' => 'Artificial trees', 'label_ar' => 'أشجار صناعية'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Style', 'title_ar' => 'النمط',
                'placeholder_en' => 'Select style', 'placeholder_ar' => 'حدد النمط',
                'description_en' => null, 'description_ar' => null,
                'name' => 'style',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'select', 'options' => [
                    'choices' => [
                        ['value' => 'modern', 'label_en' => 'Modern', 'label_ar' => 'مودرن'],
                        ['value' => 'contemporary', 'label_en' => 'Contemporary', 'label_ar' => 'معاصر'],
                        ['value' => 'classic', 'label_en' => 'Classic', 'label_ar' => 'كلاسيكي'],
                        ['value' => 'traditional', 'label_en' => 'Traditional', 'label_ar' => 'تقليدي'],
                        ['value' => 'minimalist', 'label_en' => 'Minimalist', 'label_ar' => 'بسيط (مينيمال)'],
                        ['value' => 'scandinavian', 'label_en' => 'Scandinavian', 'label_ar' => 'إسكندنافي'],
                        ['value' => 'industrial', 'label_en' => 'Industrial', 'label_ar' => 'صناعي'],
                        ['value' => 'rustic', 'label_en' => 'Rustic', 'label_ar' => 'ريفي'],
                        ['value' => 'farmhouse', 'label_en' => 'Farmhouse', 'label_ar' => 'أسلوب مزرعة'],
                        ['value' => 'bohemian', 'label_en' => 'Bohemian', 'label_ar' => 'بوهيمي'],
                        ['value' => 'mid_century_modern', 'label_en' => 'Mid-century modern', 'label_ar' => 'مودرن منتصف القرن'],
                        ['value' => 'art_deco', 'label_en' => 'Art Deco', 'label_ar' => 'آرت ديكو'],
                        ['value' => 'art_nouveau', 'label_en' => 'Art Nouveau', 'label_ar' => 'آرت نوفو'],
                        ['value' => 'coastal', 'label_en' => 'Coastal', 'label_ar' => 'ساحلي'],
                        ['value' => 'mediterranean', 'label_en' => 'Mediterranean', 'label_ar' => 'متوسطي'],
                        ['value' => 'french_country', 'label_en' => 'French country', 'label_ar' => 'ريفي فرنسي'],
                        ['value' => 'shabby_chic', 'label_en' => 'Shabby chic', 'label_ar' => 'شابي شيك'],
                        ['value' => 'vintage', 'label_en' => 'Vintage', 'label_ar' => 'فينتج'],
                        ['value' => 'retro', 'label_en' => 'Retro', 'label_ar' => 'ريترو'],
                        ['value' => 'transitional', 'label_en' => 'Transitional', 'label_ar' => 'انتقالي'],
                        ['value' => 'japandi', 'label_en' => 'Japandi', 'label_ar' => 'ياباندي'],
                        ['value' => 'japanese', 'label_en' => 'Japanese', 'label_ar' => 'ياباني'],
                        ['value' => 'wabi_sabi', 'label_en' => 'Wabi-sabi', 'label_ar' => 'وابي سابي'],
                        ['value' => 'glam', 'label_en' => 'Glam', 'label_ar' => 'فخم لامع'],
                        ['value' => 'hollywood_regency', 'label_en' => 'Hollywood Regency', 'label_ar' => 'هوليوود ريجنسي'],
                        ['value' => 'eclectic', 'label_en' => 'Eclectic', 'label_ar' => 'انتقائي'],
                        ['value' => 'neoclassical', 'label_en' => 'Neoclassical', 'label_ar' => 'كلاسيكي حديث'],
                        ['value' => 'colonial', 'label_en' => 'Colonial', 'label_ar' => 'كولونيالي'],
                        ['value' => 'islamic', 'label_en' => 'Islamic / Arabic', 'label_ar' => 'إسلامي / عربي'],
                        ['value' => 'moroccan', 'label_en' => 'Moroccan', 'label_ar' => 'مغربي'],
                        ['value' => 'andalusian', 'label_en' => 'Andalusian', 'label_ar' => 'أندلسي'],
                        ['value' => 'tropical', 'label_en' => 'Tropical', 'label_ar' => 'استوائي'],
                        ['value' => 'urban', 'label_en' => 'Urban', 'label_ar' => 'حضري'],
                        ['value' => 'loft', 'label_en' => 'Loft', 'label_ar' => 'لوفت'],
                        ['value' => 'brutalist', 'label_en' => 'Brutalist', 'label_ar' => 'بروتالي'],
                        ['value' => 'authentic', 'label_en' => 'Authentic', 'label_ar' => 'أصيل'],
                        ['value' => 'other', 'label_en' => 'Other', 'label_ar' => 'أخرى'],
                    ],
                ], 'is_required' => false,
            ],
            [
                'title_en' => 'Color', 'title_ar' => 'اللون',
                'placeholder_en' => 'Select color', 'placeholder_ar' => 'حدد اللون',
                'description_en' => null, 'description_ar' => null,
                'name' => 'color',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'select', 'options' => [
                    'choices' => [
                        ['value' => 'white', 'label_en' => 'White', 'label_ar' => 'أبيض'],
                        ['value' => 'black', 'label_en' => 'Black', 'label_ar' => 'أسود'],
                        ['value' => 'grey', 'label_en' => 'Grey', 'label_ar' => 'رمادي'],
                        ['value' => 'silver', 'label_en' => 'Silver', 'label_ar' => 'فضي'],
                        ['value' => 'gold', 'label_en' => 'Gold', 'label_ar' => 'ذهبي'],
                        ['value' => 'copper', 'label_en' => 'Copper', 'label_ar' => 'نحاسي'],
                        ['value' => 'bronze', 'label_en' => 'Bronze', 'label_ar' => 'برونزي'],
                        ['value' => 'beige', 'label_en' => 'Beige', 'label_ar' => 'بيج'],
                        ['value' => 'cream', 'label_en' => 'Cream', 'label_ar' => 'كريمي'],
                        ['value' => 'ivory', 'label_en' => 'Ivory', 'label_ar' => 'عاجي'],
                        ['value' => 'taupe', 'label_en' => 'Taupe', 'label_ar' => 'موفي رمادي'],
                        ['value' => 'tan', 'label_en' => 'Tan', 'label_ar' => 'أسمر فاتح'],
                        ['value' => 'camel', 'label_en' => 'Camel', 'label_ar' => 'جملي'],
                        ['value' => 'brown', 'label_en' => 'Brown', 'label_ar' => 'بني'],
                        ['value' => 'chocolate', 'label_en' => 'Chocolate', 'label_ar' => 'بني غامق'],
                        ['value' => 'navy', 'label_en' => 'Navy', 'label_ar' => 'كحلي'],
                        ['value' => 'blue', 'label_en' => 'Blue', 'label_ar' => 'أزرق'],
                        ['value' => 'sky_blue', 'label_en' => 'Sky blue', 'label_ar' => 'أزرق سماوي'],
                        ['value' => 'teal', 'label_en' => 'Teal', 'label_ar' => 'تركوازي غامق'],
                        ['value' => 'turquoise', 'label_en' => 'Turquoise', 'label_ar' => 'فيروزي'],
                        ['value' => 'green', 'label_en' => 'Green', 'label_ar' => 'أخضر'],
                        ['value' => 'olive', 'label_en' => 'Olive', 'label_ar' => 'زيتوني'],
                        ['value' => 'sage', 'label_en' => 'Sage', 'label_ar' => 'مريمي'],
                        ['value' => 'mint', 'label_en' => 'Mint', 'label_ar' => 'نعناعي'],
                        ['value' => 'yellow', 'label_en' => 'Yellow', 'label_ar' => 'أصفر'],
                        ['value' => 'mustard', 'label_en' => 'Mustard', 'label_ar' => 'خردلي'],
                        ['value' => 'orange', 'label_en' => 'Orange', 'label_ar' => 'برتقالي'],
                        ['value' => 'terracotta', 'label_en' => 'Terracotta', 'label_ar' => 'طيني / تيراكوتا'],
                        ['value' => 'coral', 'label_en' => 'Coral', 'label_ar' => 'مرجاني'],
                        ['value' => 'red', 'label_en' => 'Red', 'label_ar' => 'أحمر'],
                        ['value' => 'burgundy', 'label_en' => 'Burgundy', 'label_ar' => 'عنابي'],
                        ['value' => 'pink', 'label_en' => 'Pink', 'label_ar' => 'وردي'],
                        ['value' => 'blush', 'label_en' => 'Blush', 'label_ar' => 'وردي فاتح'],
                        ['value' => 'purple', 'label_en' => 'Purple', 'label_ar' => 'بنفسجي'],
                        ['value' => 'lavender', 'label_en' => 'Lavender', 'label_ar' => 'لافندر'],
                        ['value' => 'multicolor', 'label_en' => 'Multicolor', 'label_ar' => 'متعدد الألوان'],
                        ['value' => 'wood_tone', 'label_en' => 'Wood tone', 'label_ar' => 'لون خشب طبيعي'],
                        ['value' => 'transparent', 'label_en' => 'Transparent / clear', 'label_ar' => 'شفاف'],
                        ['value' => 'other', 'label_en' => 'Other', 'label_ar' => 'أخرى'],
                    ],
                ], 'is_required' => true,
            ],
            [
                'title_en' => 'Material', 'title_ar' => 'الخامة',
                'placeholder_en' => 'Select material', 'placeholder_ar' => 'حدد الخامة',
                'description_en' => null, 'description_ar' => null,
                'name' => 'material',
                'validation_rules' => ['nullable', 'string'],
                'type' => 'select', 'options' => [
                    'choices' => [
                        ['value' => 'wood', 'label_en' => 'Wood', 'label_ar' => 'خشب'],
                        ['value' => 'engineered_wood', 'label_en' => 'Engineered wood (MDF / plywood)', 'label_ar' => 'خشب مُصنّع ( MDF / خشب رقائقي )'],
                        ['value' => 'particle_board', 'label_en' => 'Particle board', 'label_ar' => 'خشب ألياف مضغوط'],
                        ['value' => 'bamboo', 'label_en' => 'Bamboo', 'label_ar' => 'خيزران'],
                        ['value' => 'rattan', 'label_en' => 'Rattan', 'label_ar' => 'روطان'],
                        ['value' => 'wicker', 'label_en' => 'Wicker', 'label_ar' => 'قش / حصير'],
                        ['value' => 'metal', 'label_en' => 'Metal', 'label_ar' => 'معدن'],
                        ['value' => 'steel', 'label_en' => 'Steel', 'label_ar' => 'فولاذ'],
                        ['value' => 'aluminum', 'label_en' => 'Aluminum', 'label_ar' => 'ألومنيوم'],
                        ['value' => 'brass', 'label_en' => 'Brass', 'label_ar' => 'نحاس أصفر'],
                        ['value' => 'chrome', 'label_en' => 'Chrome', 'label_ar' => 'كروم'],
                        ['value' => 'iron', 'label_en' => 'Wrought iron', 'label_ar' => 'حديد مطاوع'],
                        ['value' => 'glass', 'label_en' => 'Glass', 'label_ar' => 'زجاج'],
                        ['value' => 'tempered_glass', 'label_en' => 'Tempered glass', 'label_ar' => 'زجاج مقوّى'],
                        ['value' => 'acrylic', 'label_en' => 'Acrylic / plexiglass', 'label_ar' => 'أكريليك / بليكسي'],
                        ['value' => 'plastic', 'label_en' => 'Plastic', 'label_ar' => 'بلاستيك'],
                        ['value' => 'marble', 'label_en' => 'Marble', 'label_ar' => 'رخام'],
                        ['value' => 'granite', 'label_en' => 'Granite', 'label_ar' => 'جرانيت'],
                        ['value' => 'quartz', 'label_en' => 'Quartz / engineered stone', 'label_ar' => 'كوارتز / حجر صناعي'],
                        ['value' => 'ceramic', 'label_en' => 'Ceramic', 'label_ar' => 'سيراميك'],
                        ['value' => 'porcelain', 'label_en' => 'Porcelain', 'label_ar' => 'بورسلين'],
                        ['value' => 'stone', 'label_en' => 'Natural stone', 'label_ar' => 'حجر طبيعي'],
                        ['value' => 'concrete', 'label_en' => 'Concrete / cement', 'label_ar' => 'خرسانة / إسمنت'],
                        ['value' => 'fabric', 'label_en' => 'Fabric', 'label_ar' => 'قماش'],
                        ['value' => 'cotton', 'label_en' => 'Cotton', 'label_ar' => 'قطن'],
                        ['value' => 'linen', 'label_en' => 'Linen', 'label_ar' => 'كتان'],
                        ['value' => 'velvet', 'label_en' => 'Velvet', 'label_ar' => 'مخمل'],
                        ['value' => 'leather', 'label_en' => 'Leather', 'label_ar' => 'جلد طبيعي'],
                        ['value' => 'faux_leather', 'label_en' => 'Faux leather', 'label_ar' => 'جلد صناعي'],
                        ['value' => 'suede', 'label_en' => 'Suede', 'label_ar' => 'شمواه'],
                        ['value' => 'mesh', 'label_en' => 'Mesh', 'label_ar' => 'شبكة'],
                        ['value' => 'rope', 'label_en' => 'Rope / jute', 'label_ar' => 'حبل / يوت'],
                        ['value' => 'cork', 'label_en' => 'Cork', 'label_ar' => 'فلين'],
                        ['value' => 'rubber', 'label_en' => 'Rubber', 'label_ar' => 'مطاط'],
                        ['value' => 'resin', 'label_en' => 'Resin', 'label_ar' => 'راتنج'],
                        ['value' => 'laminate', 'label_en' => 'Laminate', 'label_ar' => 'لامينيت'],
                        ['value' => 'vinyl', 'label_en' => 'Vinyl', 'label_ar' => 'فينيل'],
                        ['value' => 'mirror', 'label_en' => 'Mirror surface', 'label_ar' => 'سطح مرآة'],
                        ['value' => 'mixed', 'label_en' => 'Mixed materials', 'label_ar' => 'مواد مختلطة'],
                        ['value' => 'other', 'label_en' => 'Other', 'label_ar' => 'أخرى'],
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
                'type' => 'select', 'options' => [
                    'choices' => $furnitureBrandChoices,
                ], 'is_required' => false,
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
