<?php

namespace App\Services;

use App\Models\User;
use App\Models\Achievement;

class AchievementService
{
    public static function checkFirstPost(User $user)
    {
        if ($user->posts()->count() + $user->forumTopics()->count() === 1) {
            self::award($user, 'first_post');
        }
        
        if ($user->posts()->count() + $user->forumTopics()->count() >= 50) {
            self::award($user, 'master_creator');
        }
    }

    public static function checkActiveChatter(User $user)
    {
        if ($user->comments()->count() >= 5) {
            self::award($user, 'active_chatter');
        }
    }

    public static function award(User $user, string $key)
    {
        $achievement = Achievement::where('key', $key)->first();
        if ($achievement && !$user->achievements()->where('achievements.id', $achievement->id)->exists()) {
            $user->achievements()->attach($achievement->id);
        }
    }
}
