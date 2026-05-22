<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'commentable_id',   // Yorum yapılan içeriğin ID'si (Post ID veya Topic ID)
        'commentable_type', // Yorum yapılan modelin sınıf adı (App\Models\Post veya App\Models\ForumTopic)
        'content',
    ];

    /**
     * İLİŞKİ: Bu yorumu hangi kullanıcı yaptı?
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * POLİMORFİK İLİŞKİ: Bu yorum hangi içeriğe ait?
     * Bu fonksiyon otomatik olarak commentable_id ve commentable_type sütunlarını eşleştirir.
     */
    public function commentable()
    {
        return $this->morphTo();
    }
}