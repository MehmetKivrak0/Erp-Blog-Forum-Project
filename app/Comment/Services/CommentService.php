<?php

namespace App\Comment\Services;

use App\Core\Services\BaseService;
use App\Comment\DTOs\CreateCommentDTO;
use App\Models\Comment;

class CommentService extends BaseService
{
    /**
     * Hem blog hem forum için ortak yorum oluşturma iş mantığı.
     */
    public function createComment(CreateCommentDTO $dto): Comment
    {
        return $this->executeSafe(function () use ($dto) {

            return Comment::create([
                'user_id' => $dto->userId,
                'commentable_id' => $dto->commentableId,
                'commentable_type' => $dto->commentableType,
                'content' => $dto->content,
            ]);

        }, 'Yorum kaydedilirken sistemsel bir hata oluştu.');
    }

    /**
     * En son yapılan yorumları/aktiviteleri getirir.
     */
    public function getRecentComments(int $limit = 5)
    {
        return Comment::with(['user', 'commentable'])
            ->latest()
            ->limit($limit)
            ->get();
    }
}