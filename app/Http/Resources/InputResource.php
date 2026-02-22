<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InputResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    /**
     * Resolve options so each choice has one value (same for en/ar) and a label for the request lang.
     * Structure: select/radio => { choices: [{ value, label_en, label_ar }] }; checkbox => { label_en, label_ar }.
     */
    private function resolveOptions(Request $request): ?array
    {
        $options = $this->options;
        if ($options === null) {
            return null;
        }

        $lang = app()->getLocale();
        $labelKey = $lang === 'ar' ? 'label_ar' : 'label_en';

        // select/radio: choices with same value, label_en, label_ar → add resolved label
        if (isset($options['choices']) && is_array($options['choices'])) {
            $resolved = ['choices' => []];
            foreach ($options['choices'] as $choice) {
                $resolved['choices'][] = [
                    'value' => $choice['value'] ?? null,
                    'label_en' => $choice['label_en'] ?? null,
                    'label_ar' => $choice['label_ar'] ?? null,
                    'label' => $choice[$labelKey] ?? null,
                ];
            }
            return $resolved;
        }

        // checkbox: single label_en / label_ar → add resolved label
        if (isset($options['label_en']) || isset($options['label_ar'])) {
            return [
                'label_en' => $options['label_en'] ?? null,
                'label_ar' => $options['label_ar'] ?? null,
                'label' => $options[$labelKey] ?? null,
            ];
        }

        return $options;
    }

    public function toArray(Request $request): array
    {
        $lang = app()->getLocale();
        $title = $lang === 'ar' ? $this->title_ar : $this->title_en;
        $placeholder = $lang === 'ar' ? $this->placeholder_ar : $this->placeholder_en;
        $description = $lang === 'ar' ? $this->description_ar : $this->description_en;

        return [
            'id' => $this->id,
            'screen_id' => $this->screen_id,
            'title' => $title,
            'title_en' => $this->title_en,
            'title_ar' => $this->title_ar,
            'placeholder' => $placeholder,
            'placeholder_en' => $this->placeholder_en,
            'placeholder_ar' => $this->placeholder_ar,
            'description' => $description,
            'description_en' => $this->description_en,
            'description_ar' => $this->description_ar,
            'type' => $this->type,
            'options' => $this->resolveOptions($request),
            'is_required' => $this->is_required,
            'screen' => $this->whenLoaded('screen', fn () => new ScreenResource($this->screen)),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
