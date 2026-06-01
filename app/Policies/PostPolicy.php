<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;

class PostPolicy
{
    /**
     * Determine whether the user can create posts.
     */
    public function create(User $user): bool
    {
        return $user->status === 'active';
    }

    /**
     * Determine whether the user can update the post.
     */
    public function update(User $user, Post $post): bool
    {
        if ($user->status !== 'active') {
            return false;
        }

        $userRole = is_object($user->role) ? $user->role->value : $user->role;

        return $user->id === $post->user_id || in_array($userRole, ['admin', 'developer']);
    }

    /**
     * Determine whether the user can delete the post.
     */
    public function delete(User $user, Post $post): bool
    {
        if ($user->status !== 'active') {
            return false;
        }

        $userRole = is_object($user->role) ? $user->role->value : $user->role;

        return $user->id === $post->user_id || in_array($userRole, ['admin', 'developer', 'moderator']);
    }
}
