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
                userId: auth()->id() ?? 1, // Giriş yapmış kullanıcı yoksa şimdilik id:1 kabul et
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
}