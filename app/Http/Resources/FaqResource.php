<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FaqResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lang = app()->getLocale();
        $question = $lang == 'ar' ? $this->question_ar : $this->question_en;
        $answer = $lang == 'ar' ? $this->answer_ar : $this->answer_en;

        return [
            'id' => $this->id,
            'question' => $question,
            'answer' => $answer,
            'segment' => $this->segment,
            'is_active' => (bool) $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
