<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Blog\Services\BlogService;
use App\Blog\DTOs\CreatePostDTO;
use App\Blog\DTOs\UpdatePostDTO;
use App\Http\Requests\UpdatePostRequest;
use App\Core\Enums\PostStatus;
use App\Models\Category;
use App\Models\Post;
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

    public function show(Post $post)
    {
        $post->load('tags');

        // Parse Markdown to HTML if needed (assuming simple markdown or html is stored)
        $htmlContent = Str::markdown($post->content);
        
        $tocGenerator = new \App\Services\TocGenerator();
        $tocData = $tocGenerator->generate($htmlContent);
        
        $post->parsed_content = $tocData['content'];
        $toc = $tocData['toc'];

        // Benzer yazılar (kategorisine göre)
        $relatedPosts = Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->where('status', PostStatus::PUBLISHED)
            ->latest()
            ->limit(3)
            ->get();

        return view('blog.show', compact('post', 'relatedPosts', 'toc'));
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
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'category_id' => 'nullable|integer|exists:categories,id',
            'visibility'  => 'nullable|string|in:public,private',
            'cover_image' => 'nullable|image|max:5120',
        ]);

        $categoryId = $request->input('category_id') ?? Category::where('type', 'blog')->first()?->id ?? 1;

        // Determine status: staff bypass review, normal users go through PENDING
        $userRole = auth()->user()?->role?->value ?? 'user';
        $isStaff  = in_array($userRole, ['admin', 'moderator', 'developer']);

        if ($request->input('visibility') === 'private') {
            $status = PostStatus::DRAFT;
        } elseif ($isStaff) {
            $status = PostStatus::PUBLISHED;
        } else {
            $status = PostStatus::PENDING; // Awaiting moderator review
        }

        $coverImagePath = null;
        if ($request->hasFile('cover_image')) {
            $coverImagePath = $request->file('cover_image')->store('posts/cover_images', 'public');
        }

        $dto = new CreatePostDTO(
            userId:     auth()->id() ?? 1,
            categoryId: $categoryId,
            title:      $request->title,
            slug:       Str::slug($request->title) . '-' . rand(100, 999),
            content:    $request->input('content'),
            status:     $status,
            coverImage: $coverImagePath
        );

        $post = $this->blogService->createPost($dto);

        $message = $isStaff
            ? 'Yazı başarıyla yayınlandı.'
            : 'Yazınız moderatör incelemesine gönderildi. Onaylandıktan sonra yayınlanacak.';

        return redirect()->route('home')->with('success', $message);
    }

    public function storeComment(Request $request, Post $post)
    {
        $request->validate([
            'comment' => 'required|string|min:3',
        ]);

        $dto = new \App\Comment\DTOs\CreateCommentDTO(
            userId: auth()->id() ?? 1,
            commentableId: $post->id,
            commentableType: Post::class,
            content: $request->comment
        );

        app(\App\Comment\Services\CommentService::class)->createComment($dto);

        return redirect()->route('blog.show', $post->id)->with('success', 'Yorumunuz başarıyla eklendi.');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        $categories = Category::where('type', 'blog')->get();
        if ($categories->isEmpty()) {
            $categories = Category::all();
        }

        return view('blog.edit', compact('post', 'categories'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $categoryId = $request->input('category_id') ?? $post->category_id;

        $userRole = $request->user()?->role?->value ?? 'user';
        $isStaff  = in_array($userRole, ['admin', 'moderator', 'developer']);

        if ($request->input('visibility') === 'private') {
            $status = PostStatus::DRAFT;
        } elseif ($isStaff) {
            $status = PostStatus::PUBLISHED;
        } else {
            $status = PostStatus::PENDING;
        }

        $coverImagePath = null;
        if ($request->hasFile('cover_image')) {
            $coverImagePath = $request->file('cover_image')->store('posts/cover_images', 'public');
        }

        $dto = new UpdatePostDTO(
            postId:     $post->id,
            categoryId: (int) $categoryId,
            title:      $request->title,
            content:    $request->input('content'),
            status:     $status,
            coverImage: $coverImagePath
        );

        $this->blogService->updatePost($dto);

        $message = $isStaff
            ? 'Yazı başarıyla güncellendi.'
            : 'Değişiklikleriniz moderatör incelemesine gönderildi.';

        return redirect()->route('blog.show', $post->id)->with('success', $message);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $this->blogService->deletePost($post->id);

        return redirect()->route('blog.index')->with('success', 'Yazı başarıyla silindi.');
    }
}
