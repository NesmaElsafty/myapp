<?php

namespace App\Services;

use App\Models\Content;
use Illuminate\Validation\ValidationException;

class ContentService
{
    public function getAll(array $data)
    {
        $query = Content::query()->with(['page', 'media']);

        if (!empty($data['page_id'])) {
            $query->where('page_id', (int) $data['page_id']);
        }

        if (!empty($data['type'])) {
            $query->where('type', $data['type']);
        }

        if (!empty($data['search'])) {
            $search = $data['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title_en', 'like', "%{$search}%")
                    ->orWhere('title_ar', 'like', "%{$search}%");
            });
        }

        $query->orderBy('id', 'desc');

        return $query;
    }

    public function getById(int $id): ?Content
    {
        return Content::with(['page', 'media'])->find($id);
    }

    public function create(array $data): Content
    {
        return Content::create([
            'page_id' => $data['page_id'],
            'type' => $data['type'] ?? null,
            'title_en' => $data['title_en'] ?? null,
            'title_ar' => $data['title_ar'] ?? null,
            'content_en' => $data['content_en'] ?? null,
            'content_ar' => $data['content_ar'] ?? null,
        ]);
    }

    public function update($id, array $data): Content
    {
        $content = Content::find($id);
        if (!$content) {
            throw ValidationException::withMessages(['content' => [__('messages.content_not_found')]]);
        }

        $content->page_id = $data['page_id'] ?? $content->page_id;
        $content->type = $data['type'] ?? $content->type;
        $content->title_en = $data['title_en'] ?? $content->title_en;
        $content->title_ar = $data['title_ar'] ?? $content->title_ar;
        $content->content_en = $data['content_en'] ?? $content->content_en;
        $content->content_ar = $data['content_ar'] ?? $content->content_ar;
        $content->save();

        return $content;
    }

    public function delete(int $id): bool
    {
        $content = Content::find($id);
        if (!$content) {
            throw ValidationException::withMessages(['content' => [__('messages.content_not_found')]]);
        }
        $content->delete();
        return true;
    }
}
