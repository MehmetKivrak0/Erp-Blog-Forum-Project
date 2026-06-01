<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Forum\Services\ForumService;
use App\Comment\Services\CommentService;
use App\Comment\DTOs\CreateCommentDTO;
use App\Models\ForumTopic;
use App\Models\Comment;
use App\Models\Vote;
use App\Models\Bookmark;
use Illuminate\Http\Request;

use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Forum\DTOs\CreateTopicDTO;
use App\Forum\DTOs\UpdateTopicDTO;
use Illuminate\Support\Str;
use App\Exceptions\Forum\Exceptions\TopicCreationFailedException;

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

    public function show(ForumTopic $topic)
    {
        // Benzer tartışmalar (aynı kategori)
        $relatedTopics = ForumTopic::where('category_id', $topic->category_id)
            ->where('id', '!=', $topic->id)
            ->withCount('comments')
            ->latest()
            ->limit(3)
            ->get();

        return view('forum.show', compact('topic', 'relatedTopics'));
    }

    public function storeReply(Request $request, ForumTopic $topic)
    {
        if ($topic->is_locked) {
            abort(403, 'Bu konu kilitlenmiştir, yeni yanıt yazamazsınız.');
        }

        $request->validate([
            'reply' => 'required|string|min:3',
        ]);

        $dto = new CreateCommentDTO(
            userId: auth()->id() ?? 1,
            commentableId: $topic->id,
            commentableType: ForumTopic::class,
            content: $request->reply
        );

        $this->commentService->createComment($dto);

        return redirect()->route('forum.thread', $topic->id)->with('success', 'Yorumunuz başarıyla eklendi.');
    }

    public function create()
    {
        if (auth()->user()->cannot('create', ForumTopic::class)) {
            abort(403);
        }

        $categories = \App\Models\Category::where('type', 'forum')->get();
        if ($categories->isEmpty()) {
            $categories = \App\Models\Category::all();
        }
        return view('forum.create', compact('categories'));
    }

    public function store(StoreTopicRequest $request)
    {
        // Staff (admin/moderator/developer) bypass review; regular users go pending
        $userRole = auth()->user()?->role?->value ?? 'user';
        $isStaff  = in_array($userRole, ['admin', 'moderator', 'developer']);

        $dto = new CreateTopicDTO(
            userId:     auth()->id() ?? 1,
            categoryId: $request->category_id,
            title:      $request->title,
            content:    $request->input('content'),
            isPinned:   $isStaff ? $request->boolean('is_pinned', false) : false,
            isLocked:   $isStaff ? $request->boolean('is_locked', false) : false
        );

        try {
            $topic = $this->forumService->createTopic($dto);

            // Normal users: flag topic as pending review
            if (!$isStaff) {
                $topic->is_pending = true;
                $topic->save();
            }

            $message = $isStaff
                ? 'Tartışma konusu başarıyla oluşturuldu.'
                : 'Konunuz moderatör incelemesine gönderildi. Onaylandıktan sonra görünür olacak.';

            return redirect()->route('forum.index')->with('success', $message);
        } catch (TopicCreationFailedException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit(ForumTopic $topic)
    {
        $this->authorize('update', $topic);

        $categories = \App\Models\Category::where('type', 'forum')->get();
        if ($categories->isEmpty()) {
            $categories = \App\Models\Category::all();
        }

        return view('forum.edit', compact('topic', 'categories'));
    }

    public function update(UpdateTopicRequest $request, ForumTopic $topic)
    {
        $user = $request->user();
        $userRole = is_object($user->role) ? $user->role->value : $user->role;
        $isStaff = in_array($userRole, ['admin', 'developer', 'moderator']);

        $dto = new UpdateTopicDTO(
            topicId: $topic->id,
            categoryId: $request->category_id,
            title: $request->title,
            content: $request->input('content'),
            isPinned: $isStaff ? $request->boolean('is_pinned', false) : null,
            isLocked: $isStaff ? $request->boolean('is_locked', false) : null
        );

        $this->forumService->updateTopic($dto);

        return redirect()->route('forum.thread', $topic->id)->with('success', 'Tartışma konusu başarıyla güncellendi.');
    }

    public function destroy(ForumTopic $topic)
    {
        $this->authorize('delete', $topic);

        $this->forumService->deleteTopic($topic->id);

        return redirect()->route('forum.index')->with('success', 'Tartışma konusu başarıyla silindi.');
    }

    public function vote(Request $request, ForumTopic $topic)
    {
        $request->validate([
            'value' => 'required|integer|in:1,-1,0',
        ]);

        $userId = auth()->id();
        $value = (int) $request->input('value');

        if ($value === 0) {
            $topic->votes()->where('user_id', $userId)->delete();
        } else {
            $topic->votes()->updateOrCreate(
                ['user_id' => $userId],
                ['value' => $value]
            );
        }

        return response()->json([
            'success' => true,
            'score' => $topic->score,
            'user_vote' => $value === 0 ? null : $value,
        ]);
    }

    public function voteReply(Request $request, Comment $comment)
    {
        $request->validate([
            'value' => 'required|integer|in:1,-1,0',
        ]);

        $userId = auth()->id();
        $value = (int) $request->input('value');

        if ($value === 0) {
            $comment->votes()->where('user_id', $userId)->delete();
        } else {
            $comment->votes()->updateOrCreate(
                ['user_id' => $userId],
                ['value' => $value]
            );
        }

        return response()->json([
            'success' => true,
            'score' => $comment->score,
            'user_vote' => $value === 0 ? null : $value,
        ]);
    }

    public function bookmark(Request $request, ForumTopic $topic)
    {
        $userId = auth()->id();

        $existing = $topic->bookmarks()->where('user_id', $userId)->first();

        if ($existing) {
            $existing->delete();
            $bookmarked = false;
        } else {
            $topic->bookmarks()->create([
                'user_id' => $userId,
            ]);
            $bookmarked = true;
        }

        return response()->json([
            'success' => true,
            'bookmarked' => $bookmarked,
        ]);
    }

    public function toggleSolution(Request $request, ForumTopic $topic)
    {
        $request->validate([
            'comment_id' => 'required|integer|exists:comments,id',
        ]);

        $commentId = (int) $request->input('comment_id');

        // Verify that the comment belongs to this topic
        $comment = Comment::where('id', $commentId)
            ->where('commentable_id', $topic->id)
            ->where('commentable_type', ForumTopic::class)
            ->firstOrFail();

        // Authorize: Only topic author or admin/moderator/developer can select the solution
        $user = auth()->user();
        $userRole = is_object($user->role) ? $user->role->value : $user->role;
        $isStaff = in_array($userRole, ['admin', 'moderator', 'developer']);

        if ($topic->user_id !== $user->id && !$isStaff) {
            abort(403, 'Bu işlem için yetkiniz bulunmamaktadır.');
        }

        // Toggling logic:
        if ($topic->solution_comment_id === $commentId) {
            $topic->solution_comment_id = null;
        } else {
            $topic->solution_comment_id = $commentId;
        }
        $topic->save();

        return response()->json([
            'success' => true,
            'solution_comment_id' => $topic->solution_comment_id,
        ]);
    }
}
