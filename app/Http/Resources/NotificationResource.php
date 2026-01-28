<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lang = $request->header('Accept-Language', 'en');
        
        return [
            'id' => $this->id,
            'title' => $lang === 'ar' ? $this->title_ar : $this->title_en,
            'title_en' => $this->title_en,
            'title_ar' => $this->title_ar,
            'content' => $lang === 'ar' ? $this->content_ar : $this->content_en,
            'content_en' => $this->content_en,
            'content_ar' => $this->content_ar,
            'type' => $this->type,
            'target_type' => $this->target_type,
            'status' => $this->status,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
