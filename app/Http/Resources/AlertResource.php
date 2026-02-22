<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
class AlertResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $lang = app()->getLocale();
        Auth::check() ? $this->user_id == Auth::user()->id : false;
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $lang === 'ar' ? $this->title_ar : $this->title_en,
            'content' => $lang === 'ar' ? $this->content_ar : $this->content_en,
            'is_read' => $this->is_read,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function with(Request $request): array
    {
        return [
            'success' => true,
        ];
    }
}
