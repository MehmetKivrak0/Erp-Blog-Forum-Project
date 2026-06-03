<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index(Request $request)
    {
        $type = $request->query('type', 'blog');
        $blogCategories = null;
        $forumCategories = null;

        if ($type === 'blog') {
            $blogCategories = Category::where('type', 'blog')->withCount('posts')->orderBy('name')->paginate(4, ['*'], 'blog_page');
        } else {
            $forumCategories = Category::where('type', 'forum')->withCount('forumTopics')->orderBy('name')->paginate(4, ['*'], 'forum_page');
        }

        return view('admin.categories', compact('blogCategories', 'forumCategories', 'type'));
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'type' => 'required|in:blog,forum'
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'type' => $request->type,
        ]);

        return back()->with('success', 'Kategori başarıyla oluşturuldu.');
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'type' => 'required|in:blog,forum'
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'type' => $request->type,
        ]);

        return back()->with('success', 'Kategori başarıyla güncellendi.');
    }

    /**
     * Remove the specified category.
     */
    public function destroy(Category $category)
    {
        // Check for attached content
        $postsCount = $category->posts()->count();
        $topicsCount = $category->forumTopics()->count();

        if ($postsCount > 0 || $topicsCount > 0) {
            return back()->with('error', 'Bu kategori silinemez çünkü içinde aktif gönderiler veya konular barındırmaktadır.');
        }

        $category->delete();

        return back()->with('success', 'Kategori başarıyla silindi.');
    }
}
