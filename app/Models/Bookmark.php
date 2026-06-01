<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bookmarkable_id',
        'bookmarkable_type',
    ];

    /**
     * Get the parent bookmarkable model.
     */
    public function bookmarkable()
    {
        return $this->morphTo();
    }

    /**
     * Get the user who bookmarked.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
