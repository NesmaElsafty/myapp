<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InquiryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $files = $this->getMedia('files');
        $files = $files->map(function ($file) use ($request) {
            return [
                'id' => $file->id,
                'url' => str_replace('public/', '', $file->getUrl()),
                'name' => $file->name,
                'type' => $file->mime_type,
            ];
        });  
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'message' => $this->message,
            'account_type' => $this->account_type,
            'is_replied' => (bool) $this->is_replied,
            'reply_message' => $this->reply_message,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'files' => $files,
        ];
    }
}
