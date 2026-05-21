<?php

namespace App\Models;

use App\Core\Enums\PostStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'content',
        'status',
    ];

    // PHP 8.1 Enum eşleştirmesi: Veritabanındaki metni otomatik olarak PostStatus Enum'ına çevirir
    protected $casts = [
        'status' => PostStatus::class,
    ];

    /**
     * İLİŞKİ: Bu yazıyı hangi kullanıcı yazdı?
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * İLİŞKİ: Bu yazı hangi kategoriye ait?
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * POLİMORFİK İLİŞKİ: Bu yazıya ait yorumlar (Ortak comments tablosundan gelir)
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}