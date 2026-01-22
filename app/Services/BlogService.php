<?php

namespace App\Services;

use App\Models\Blog;
use Illuminate\Validation\ValidationException;

class BlogService
{
    public function getAll($data)
    {
        $query = Blog::query();

        if (isset($data['search'])) {
            $search = $data['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title_en', 'like', "%{$search}%")
                    ->orWhere('title_ar', 'like', "%{$search}%");
            });
        }
        
            $query->orderBy('id', 'desc');
        return $query;
    }

    public function getById($id)
    {
        return Blog::find($id);
    }

    public function create($data)
    {
        return Blog::create([
            'title_en' => $data['title_en'],
            'title_ar' => $data['title_ar'],
            'description_en' => $data['description_en'],
            'description_ar' => $data['description_ar'],
            'is_active' => $data['is_active'] ?? true,
        ]);
    }

    public function update($id, $data)
    {
        $blog = Blog::find($id);
        if (!$blog) {
            throw ValidationException::withMessages(['blog' => ['Blog not found']]);
        }

        $blog->title_en = $data['title_en'] ?? $blog->title_en;
        $blog->title_ar = $data['title_ar'] ?? $blog->title_ar;
        $blog->description_en = $data['description_en'] ?? $blog->description_en;
        $blog->description_ar = $data['description_ar'] ?? $blog->description_ar;
        $blog->is_active = $data['is_active'] ?? $blog->is_active;

        $blog->save();

        return $blog;
    }

    public function delete($id)
    {
        $blog = Blog::find($id);
        if (!$blog) {
            throw ValidationException::withMessages(['blog' => ['Blog not found']]);
        }
        $blog->delete();
        return true;
    }
}
