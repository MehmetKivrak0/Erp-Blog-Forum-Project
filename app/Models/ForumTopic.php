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
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_locked' => 'boolean',
    ];

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
}
