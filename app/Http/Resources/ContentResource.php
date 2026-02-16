<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lang = $request->header('lang') ?? 'ar';
        $title = $lang === 'ar' ? $this->title_ar : $this->title_en;
        $content = $lang === 'ar' ? $this->content_ar : $this->content_en;

        $image = null;
        if ($this->type === 'img_text' && $this->hasMedia('image')) {
            $image = str_replace('public/', '', $this->getFirstMediaUrl('image'));
        }

        return [
            'id' => $this->id,
            'page_id' => $this->page_id,
            'type' => $this->type,
            'title' => $title,
            'content' => $content,
            'title_en' => $this->title_en,
            'title_ar' => $this->title_ar,
            'content_en' => $this->content_en,
            'content_ar' => $this->content_ar,
            'image' => $image,
            'page' => $this->whenLoaded('page', fn () => new PageResource($this->page)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
