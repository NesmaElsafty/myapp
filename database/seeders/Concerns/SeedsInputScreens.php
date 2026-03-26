<?php

namespace Database\Seeders\Concerns;

use App\Models\Input;
use App\Models\Screen;

trait SeedsInputScreens
{
    protected function registerInputCreatingHook(): void
    {
        Input::creating(function (Input $input) {
            $source = $input->name ?: $input->key ?: $input->title_en ?: $input->title_ar;

            if ($source !== null) {
                $normalized = preg_replace('/\s+/', '_', trim($source));
                $input->name = $normalized;

                if (empty($input->key)) {
                    $input->key = $normalized;
                }
            }
        });
    }

    protected function seedInputsForScreen(?Screen $screen, array $inputs): void
    {
        if (!$screen) {
            return;
        }

        Input::where('screen_id', $screen->id)->delete();

        foreach ($inputs as $input) {
            Input::create(array_merge(
                $input,
                [
                    'screen_id' => $screen->id,
                    'key' => $input['name'] ?? $input['title_en'],
                    'is_active' => $input['is_active'] ?? true,
                ]
            ));
        }
    }
}
