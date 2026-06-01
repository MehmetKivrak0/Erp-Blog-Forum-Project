<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForumTopic extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'content',
        'is_pinned',
        'is_locked',
        'is_pending',
        'solution_comment_id',
    ];

    protected $casts = [
        'is_pinned'   => 'boolean',
        'is_locked'   => 'boolean',
        'is_pending'  => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($topic) {
            if (empty($topic->slug)) {
                $topic->slug = \Illuminate\Support\Str::slug($topic->title) . '-' . rand(100, 999);
            }
        });
    }

    /**
     * İLİŞKİ: Bu konuyu hangi kullanıcı açtı?
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * İLİŞKİ: Bu konu hangi kategoriye ait?
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * POLİMORFİK İLİŞKİ: Bu konuya ait yorumlar (veya yanıtlar)
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * POLİMORFİK İLİŞKİ: Bu konuya ait oylar.
     */
    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    /**
     * POLİMORFİK İLİŞKİ: Bu konuya ait yer işaretleri.
     */
    public function bookmarks()
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }

    /**
     * Toplam oy skorunu hesaplar (upvotes - downvotes).
     */
    public function getScoreAttribute(): int
    {
        return (int) $this->votes()->sum('value');
    }

    /**
     * Verilen kullanıcının bu konudaki oy değerini döner (1, -1 veya null).
     */
    public function userVoteValue(?User $user): ?int
    {
        if (!$user) {
            return null;
        }

        return $this->votes()->where('user_id', $user->id)->value('value');
    }

    /**
     * Verilen kullanıcının bu konuyu favoriye ekleyip eklemediğini döner.
     */
    public function isBookmarkedBy(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        return $this->bookmarks()->where('user_id', $user->id)->exists();
    }

    /**
     * İLİŞKİ: Bu konunun doğrulanmış çözümü olan yorum.
     */
    public function solutionComment()
    {
        return $this->belongsTo(Comment::class, 'solution_comment_id');
    }

    /**
     * Konunun doğrulanmış bir çözümü olup olmadığını döner.
     */
    public function hasSolution(): bool
    {
        return !empty($this->solution_comment_id);
    }
}
