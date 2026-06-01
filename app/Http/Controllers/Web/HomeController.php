<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Blog\Services\BlogService;
use App\Forum\Services\ForumService;
use App\Comment\Services\CommentService;
use App\Models\Category;
use App\Models\User;
use App\Models\Post;
use App\Models\ForumTopic;
use App\Core\Enums\PostStatus;

class HomeController extends Controller
{
    public function __construct(
        protected BlogService $blogService,
        protected ForumService $forumService,
        protected CommentService $commentService
    ) {}

    public function index(\Illuminate\Http\Request $request)
    {
        $currentCategory = $request->query('category');

        // 1. Kategorileri çek (sadece içeriği olan kategoriler)
        $categories = Category::whereHas('posts')->orWhereHas('forumTopics')->get();

        // 2. Yayınlanmış en son blog yazılarını çek (Kategori filtreli ve sayfalı)
        $posts = $this->blogService->getPublishedPostsPaginated($currentCategory, 5);

        // 3. Son açılan forum konularını çek (Kategori filtreli)
        $topics = $this->forumService->getAllTopics($currentCategory)->take(5);

        // 4. Son aktiviteleri (yorumları) çek (Limit: 5)
        $recentActivities = $this->commentService->getRecentComments(5);

        // 5. İstatistikleri hesapla
        $stats = [
            'total_members' => User::count(),
            'active_discussions' => ForumTopic::count(),
            'articles_published' => Post::where('status', PostStatus::PUBLISHED)->count(),
            'solution_rate' => 94 // Varsayılan/Statik oran
        ];

        return view('home', compact('categories', 'posts', 'topics', 'recentActivities', 'stats', 'currentCategory'));
    }
}
