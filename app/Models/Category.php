<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Veritabanına toplu ekleme yaparken hangi sütunlara izin vereceğimizi belirtiyoruz (Güvenlik)
    protected $fillable = [
        'name',
        'slug',
        'type', // 'blog' veya 'forum'
    ];

    /**
     * İLİŞKİ: Bir kategorinin birden fazla Blog yazısı olabilir (1-N)
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * İLİŞKİ: Bir kategorinin birden fazla Forum konusu olabilir (1-N)
     */
    public function forumTopics()
    {
        // İleride ForumTopic modelini de dolduracağız
        return $this->hasMany(ForumTopic::class); 
    }
}