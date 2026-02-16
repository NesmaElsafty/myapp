<?php

namespace App\Services;

use App\Models\Page;
use Illuminate\Validation\ValidationException;

class PageService
{
    public function getAll(array $data)
    {
        $query = Page::query()->with('contents');

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

    public function getById(int $id): ?Page
    {
        return Page::with('contents')->find($id);
    }

    public function create(array $data): Page
    {
        return Page::create([
            'title_en' => $data['title_en'] ?? null,
            'title_ar' => $data['title_ar'] ?? null,
            'content_en' => $data['content_en'] ?? null,
            'content_ar' => $data['content_ar'] ?? null,
        ]);
    }

    public function update($id, array $data): Page
    {
        $page = Page::find($id);
        if (!$page) {
            throw ValidationException::withMessages(['page' => [__('messages.page_not_found')]]);
        }

        $page->title_en = $data['title_en'] ?? $page->title_en;
        $page->title_ar = $data['title_ar'] ?? $page->title_ar;
        $page->content_en = $data['content_en'] ?? $page->content_en;
        $page->content_ar = $data['content_ar'] ?? $page->content_ar;
        $page->save();

        return $page;
    }

    public function delete(int $id): bool
    {
        $page = Page::find($id);
        if (!$page) {
            throw ValidationException::withMessages(['page' => [__('messages.page_not_found')]]);
        }
        $page->delete();
        return true;
    }
}
