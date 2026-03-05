<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Input;
use App\Models\Item;
use App\Models\ItemInputValue;
use App\Models\Screen;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ItemWizardTest extends TestCase
{
    use RefreshDatabase;

    protected function createUser(): User
    {
        return User::factory()->create([
            'type' => 'individual',
        ]);
    }

    protected function createBasicStructure(): array
    {
        $category = Category::factory()->create();

        $screen1 = Screen::factory()->create([
            'category_id' => $category->id,
            'position' => 1,
        ]);

        $screen2 = Screen::factory()->create([
            'category_id' => $category->id,
            'position' => 2,
        ]);

        return [$category, $screen1, $screen2];
    }

    public function test_init_creates_item_in_progress_and_returns_first_screen_inputs(): void
    {
        $user = $this->createUser();
        [$category, $screen1] = $this->createBasicStructure();

        $input = Input::create([
            'screen_id' => $screen1->id,
            'key' => 'title',
            'name' => 'title',
            'title_en' => 'Title',
            'title_ar' => 'العنوان',
            'type' => 'text',
            'options' => null,
            'is_required' => false,
            'is_active' => true,
            'validation_rules' => ['nullable', 'string'],
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/items/init', [
                'category_id' => $category->id,
            ]);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'item' => ['id', 'status', 'current_screen_id'],
            'steps_count',
            'current_screen' => ['id'],
            'inputs' => [
                [
                    'id',
                    'key',
                    'type',
                    'is_required',
                    'validation_rules',
                    'options',
                    'value',
                    'media',
                ],
            ],
        ]);

        $itemId = $response->json('item.id');
        $item = Item::find($itemId);

        $this->assertNotNull($item);
        $this->assertEquals('in_progress', $item->status);
        $this->assertEquals($screen1->id, $item->current_screen_id);
    }

    public function test_update_text_input_saves_value(): void
    {
        $user = $this->createUser();
        [$category, $screen1] = $this->createBasicStructure();

        $input = Input::create([
            'screen_id' => $screen1->id,
            'key' => 'title',
            'name' => 'title',
            'title_en' => 'Title',
            'title_ar' => 'العنوان',
            'type' => 'text',
            'options' => null,
            'is_required' => false,
            'is_active' => true,
            'validation_rules' => ['nullable', 'string'],
        ]);

        $item = Item::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'status' => 'in_progress',
            'current_screen_id' => $screen1->id,
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->patchJson("/api/items/{$item->id}/inputs/{$input->id}", [
                'value' => 'My title',
            ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('item_input_values', [
            'item_id' => $item->id,
            'input_id' => $input->id,
            'value' => 'My title',
        ]);
    }

    public function test_update_single_file_input_replaces_media_in_correct_collection(): void
    {
        Storage::fake('public');

        $user = $this->createUser();
        [$category, $screen1] = $this->createBasicStructure();

        $input = Input::create([
            'screen_id' => $screen1->id,
            'key' => 'photo',
            'name' => 'photo',
            'title_en' => 'Photo',
            'title_ar' => 'صورة',
            'type' => 'image',
            'options' => null,
            'is_required' => false,
            'is_active' => true,
            'validation_rules' => null,
        ]);

        $item = Item::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'status' => 'in_progress',
            'current_screen_id' => $screen1->id,
        ]);

        // First upload
        $file1 = UploadedFile::fake()->image('photo1.jpg');

        $response = $this->actingAs($user, 'sanctum')
            ->withHeader('Accept', 'application/json')
            ->patch("/api/items/{$item->id}/inputs/{$input->id}", [
                'value' => $file1,
            ]);

        $response->assertStatus(200);

        $item->refresh();

        $media = $item->getMedia('photo');
        $this->assertCount(1, $media);
        $this->assertEquals('photo1.jpg', $media->first()->file_name);

        // Second upload should replace previous
        $file2 = UploadedFile::fake()->image('photo2.jpg');

        $response = $this->actingAs($user, 'sanctum')
            ->withHeader('Accept', 'application/json')
            ->patch("/api/items/{$item->id}/inputs/{$input->id}", [
                'value' => $file2,
            ]);

        $response->assertStatus(200);

        $item->refresh();

        $media = $item->getMedia('photo');
        $this->assertCount(1, $media);
        $this->assertEquals('photo2.jpg', $media->first()->file_name);
    }

    public function test_update_multi_file_input_appends_multiple_files(): void
    {
        Storage::fake('public');

        $user = $this->createUser();
        [$category, $screen1] = $this->createBasicStructure();

        $input = Input::create([
            'screen_id' => $screen1->id,
            'key' => 'attachments',
            'name' => 'attachments',
            'title_en' => 'Attachments',
            'title_ar' => 'مرفقات',
            'type' => 'multi_file',
            'options' => null,
            'is_required' => false,
            'is_active' => true,
            'validation_rules' => null,
        ]);

        $item = Item::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'status' => 'in_progress',
            'current_screen_id' => $screen1->id,
        ]);

        $filesFirst = [
            UploadedFile::fake()->image('file1.jpg'),
            UploadedFile::fake()->image('file2.jpg'),
        ];

        $response = $this->actingAs($user, 'sanctum')
            ->withHeader('Accept', 'application/json')
            ->patch("/api/items/{$item->id}/inputs/{ $input->id}", [
                'value' => $filesFirst,
            ]);

        $response->assertStatus(200);

        $item->refresh();
        $media = $item->getMedia('attachments');
        $this->assertCount(2, $media);

        $filesSecond = [
            UploadedFile::fake()->image('file3.jpg'),
            UploadedFile::fake()->image('file4.jpg'),
        ];

        $response = $this->actingAs($user, 'sanctum')
            ->withHeader('Accept', 'application/json')
            ->patch("/api/items/{$item->id}/inputs/{$input->id}", [
                'value' => $filesSecond,
            ]);

        $response->assertStatus(200);

        $item->refresh();
        $media = $item->getMedia('attachments');
        $this->assertCount(4, $media);
    }

    public function test_finalize_fails_when_required_input_missing(): void
    {
        $user = $this->createUser();
        [$category, $screen1] = $this->createBasicStructure();

        $input = Input::create([
            'screen_id' => $screen1->id,
            'key' => 'title',
            'name' => 'title',
            'title_en' => 'Title',
            'title_ar' => 'العنوان',
            'type' => 'text',
            'options' => null,
            'is_required' => true,
            'is_active' => true,
            'validation_rules' => ['required', 'string'],
        ]);

        $item = Item::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'status' => 'in_progress',
            'current_screen_id' => $screen1->id,
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->postJson("/api/items/{$item->id}/finalize", [
                'name' => 'Static name',
            ]);

        $response->assertStatus(422);
        $this->assertArrayHasKey('errors', $response->json());
    }

    public function test_finalize_succeeds_when_all_required_satisfied(): void
    {
        Storage::fake('public');

        $user = $this->createUser();
        [$category, $screen1] = $this->createBasicStructure();

        $textInput = Input::create([
            'screen_id' => $screen1->id,
            'key' => 'title',
            'name' => 'title',
            'title_en' => 'Title',
            'title_ar' => 'العنوان',
            'type' => 'text',
            'options' => null,
            'is_required' => true,
            'is_active' => true,
            'validation_rules' => ['required', 'string'],
        ]);

        $fileInput = Input::create([
            'screen_id' => $screen1->id,
            'key' => 'photo',
            'name' => 'photo',
            'title_en' => 'Photo',
            'title_ar' => 'صورة',
            'type' => 'image',
            'options' => null,
            'is_required' => true,
            'is_active' => true,
            'validation_rules' => null,
        ]);

        $item = Item::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'status' => 'in_progress',
            'current_screen_id' => $screen1->id,
        ]);

        ItemInputValue::create([
            'item_id' => $item->id,
            'input_id' => $textInput->id,
            'value' => 'My title',
        ]);

        $item
            ->addMedia(UploadedFile::fake()->image('photo.jpg')->getPathname())
            ->usingFileName('photo.jpg')
            ->toMediaCollection('photo');

        $response = $this->actingAs($user, 'sanctum')
            ->postJson("/api/items/{$item->id}/finalize", [
                'name' => 'Static name',
            ]);

        $response->assertStatus(200);

        $item->refresh();

        $this->assertEquals('completed', $item->status);
        $this->assertNotNull($item->completed_at);
    }

    public function test_delete_media_deletes_only_when_belongs_to_item_and_input_collection(): void
    {
        Storage::fake('public');

        $user = $this->createUser();
        [$category, $screen1] = $this->createBasicStructure();

        $input = Input::create([
            'screen_id' => $screen1->id,
            'key' => 'photo',
            'name' => 'photo',
            'title_en' => 'Photo',
            'title_ar' => 'صورة',
            'type' => 'image',
            'options' => null,
            'is_required' => false,
            'is_active' => true,
            'validation_rules' => null,
        ]);

        $item = Item::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'status' => 'in_progress',
            'current_screen_id' => $screen1->id,
        ]);

        $media = $item
            ->addMedia(UploadedFile::fake()->image('photo.jpg')->getPathname())
            ->usingFileName('photo.jpg')
            ->toMediaCollection('photo');

        $this->assertCount(1, $item->getMedia('photo'));

        $response = $this->actingAs($user, 'sanctum')
            ->deleteJson("/api/items/{$item->id}/inputs/{$input->id}/media/{$media->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'deleted_media_id' => $media->id,
            'input_key' => $input->key,
        ]);

        $item->refresh();
        $this->assertCount(0, $item->getMedia('photo'));
    }
}

