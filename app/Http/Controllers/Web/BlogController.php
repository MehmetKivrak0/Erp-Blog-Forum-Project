<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Blog\Services\BlogService;
use App\Blog\DTOs\CreatePostDTO;
use App\Core\Enums\PostStatus;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function __construct(
        protected BlogService $blogService
    ) {}

    public function index(Request $request)
    {
        $categorySlug = $request->query('category');
        $posts = $this->blogService->getPublishedPosts($categorySlug);
        $categories = Category::where('type', 'blog')->get();
        if ($categories->isEmpty()) {
            $categories = Category::all();
        }
        return view('blog.index', compact('posts', 'categories'));
    }

    public function show(int $id)
    {
        $post = $this->blogService->getPostDetails($id);
        if (!$post) {
            abort(404, 'Blog yazısı bulunamadı.');
        }

        // Benzer yazılar (kategorisine göre)
        $relatedPosts = \App\Models\Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->where('status', PostStatus::PUBLISHED)
            ->latest()
            ->limit(3)
            ->get();

        return view('blog.show', compact('post', 'relatedPosts'));
    }

    public function create()
    {
        $categories = Category::where('type', 'blog')->get();
        if ($categories->isEmpty()) {
            $categories = Category::all();
        }
        return view('blog.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'nullable|integer|exists:categories,id',
            'visibility' => 'nullable|string|in:public,private',
        ]);

        $categoryId = $request->input('category_id') ?? Category::where('type', 'blog')->first()?->id ?? 1;

        $status = $request->input('visibility') === 'private' ? PostStatus::DRAFT : PostStatus::PUBLISHED;

        $dto = new CreatePostDTO(
            userId: auth()->id() ?? 1,
            categoryId: $categoryId,
            title: $request->title,
            slug: Str::slug($request->title) . '-' . rand(100, 999),
            content: $request->input('content'),
            status: $status
        );

        $post = $this->blogService->createPost($dto);

        return redirect()->route('blog.show', $post->id)->with('success', 'Yazı başarıyla yayınlandı.');
    }

    public function storeComment(Request $request, int $id)
    {
        $request->validate([
            'comment' => 'required|string|min:3',
        ]);

        $dto = new \App\Comment\DTOs\CreateCommentDTO(
            userId: auth()->id() ?? 1,
            commentableId: $id,
            commentableType: \App\Models\Post::class,
            content: $request->comment
        );

        app(\App\Comment\Services\CommentService::class)->createComment($dto);

        return redirect()->route('blog.show', $id)->with('success', 'Yorumunuz başarıyla eklendi.');
    }
}
