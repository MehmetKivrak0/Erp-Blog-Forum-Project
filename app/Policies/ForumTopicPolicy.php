<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ForumTopic;

class ForumTopicPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->status === 'active';
    }

    /**
     * Determine whether the user can update the forum topic.
     */
    public function update(User $user, ForumTopic $topic): bool
    {
        if ($user->status !== 'active') {
            return false;
        }

        $userRole = is_object($user->role) ? $user->role->value : $user->role;

        return $user->id === $topic->user_id || in_array($userRole, ['admin', 'developer', 'moderator']);
    }

    /**
     * Determine whether the user can delete the forum topic.
     */
    public function delete(User $user, ForumTopic $topic): bool
    {
        if ($user->status !== 'active') {
            return false;
        }

        $userRole = is_object($user->role) ? $user->role->value : $user->role;

        return $user->id === $topic->user_id || in_array($userRole, ['admin', 'developer', 'moderator']);
    }
}
