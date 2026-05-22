<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Forum\Services\ForumService;
use App\Comment\Services\CommentService;
use App\Comment\DTOs\CreateCommentDTO;
use App\Models\ForumTopic;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function __construct(
        protected ForumService $forumService,
        protected CommentService $commentService
    ) {}

    public function index(Request $request)
    {
        $categorySlug = $request->query('category');
        $topics = $this->forumService->getAllTopics($categorySlug);
        $categories = \App\Models\Category::where('type', 'forum')->get();
        if ($categories->isEmpty()) {
            $categories = \App\Models\Category::all();
        }
        return view('forum.index', compact('topics', 'categories'));
    }

    public function show(int $id)
    {
        $topic = $this->forumService->getTopicDetails($id);
        if (!$topic) {
            abort(404, 'Tartışma konusu bulunamadı.');
        }

        // Benzer tartışmalar (aynı kategori)
        $relatedTopics = ForumTopic::where('category_id', $topic->category_id)
            ->where('id', '!=', $topic->id)
            ->withCount('comments')
            ->latest()
            ->limit(3)
            ->get();

        return view('forum.show', compact('topic', 'relatedTopics'));
    }

    public function storeReply(Request $request, int $id)
    {
        $request->validate([
            'reply' => 'required|string|min:3',
        ]);

        $dto = new CreateCommentDTO(
            userId: auth()->id() ?? 1,
            commentableId: $id,
            commentableType: ForumTopic::class,
            content: $request->reply
        );

        $this->commentService->createComment($dto);

        return redirect()->route('forum.thread', $id)->with('success', 'Yorumunuz başarıyla eklendi.');
    }
}
