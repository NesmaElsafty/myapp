<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TermResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lang = $request->header('lang') ?? 'ar';
        $title = $lang == 'ar' ? $this->title_ar : $this->title_en;
        $content = $lang == 'ar' ? $this->content_ar : $this->content_en;
        
        return [
            'id' => $this->id,
            'title' => $title,
            'content' => $content,
            'type' => $this->type,
            'is_active' => (bool) $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
