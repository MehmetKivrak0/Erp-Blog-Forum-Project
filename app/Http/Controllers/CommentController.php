<?php

namespace App\Http\Controllers;

use App\Core\Controllers\BaseController;
use App\Comment\Services\CommentService;
use App\Comment\DTOs\CreateCommentDTO;
use App\Http\Requests\StoreCommentRequest;

class CommentController extends BaseController
{
    public function __construct(
        protected CommentService $commentService
    ) {
    }

    /**
     * Tek bir metotla hem Blog'a hem Forum'a yorum atılmasını sağlar.
     */
    public function store(StoreCommentRequest $request)
    {
        try {
            $dto = new CreateCommentDTO(
                userId: auth()->id(),
                commentableId: $request->validated('commentable_id'),
                commentableType: $request->validated('commentable_type'),
                content: $request->validated('content')
            );

            $comment = $this->commentService->createComment($dto);

            return $this->sendSuccess($comment, 'Yorumunuz başarıyla eklendi.', 201);

        } catch (\Exception $e) {
            return $this->sendError('Yorum eklenemedi.', [$e->getMessage()], 500);
        }
    }

    /**
     * Yorum günceller (Sadece yorumun sahibi)
     */
    public function update(\App\Http\Requests\UpdateCommentRequest $request, \App\Models\Comment $comment)
    {
        // Yetki kontrolü: Kullanıcı bu yorumu güncelleyebilir mi?
        $this->authorize('update', $comment);

        try {
            $dto = new \App\Comment\DTOs\UpdateCommentDTO(
                content: $request->validated('content')
            );

            $updatedComment = $this->commentService->updateComment($comment, $dto);

            return $this->sendSuccess($updatedComment, 'Yorum başarıyla güncellendi.');
        } catch (\Exception $e) {
            return $this->sendError('Yorum güncellenemedi.', [$e->getMessage()], 500);
        }
    }

    /**
     * Yorum siler (Sadece yorumun sahibi)
     */
    public function destroy(\App\Models\Comment $comment)
    {
        // Yetki kontrolü: Kullanıcı bu yorumu silebilir mi?
        $this->authorize('delete', $comment);

        try {
            $this->commentService->deleteComment($comment);

            return $this->sendSuccess(null, 'Yorum başarıyla silindi.');
        } catch (\Exception $e) {
            return $this->sendError('Yorum silinemedi.', [$e->getMessage()], 500);
        }
    }
}