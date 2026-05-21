<?php

namespace App\Blog\Repositories;

use App\Core\Interfaces\EloquentRepositoryInterface;
use App\Core\Repositories\BaseRepository;
use App\Models\Post;

class BlogRepository extends BaseRepository implements EloquentRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
}
