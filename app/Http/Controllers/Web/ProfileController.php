<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        // 1. Fetch activities
        $posts = $user->posts()->latest()->limit(5)->get()->map(function ($item) {
            $item->activity_type = 'post';
            $item->activity_time = $item->created_at;
            return $item;
        });

        $topics = $user->forumTopics()->latest()->limit(5)->get()->map(function ($item) {
            $item->activity_type = 'topic';
            $item->activity_time = $item->created_at;
            return $item;
        });

        $comments = $user->comments()->with('commentable')->latest()->limit(5)->get()->map(function ($item) {
            $item->activity_type = 'comment';
            $item->activity_time = $item->created_at;
            return $item;
        });

        $activities = collect()
            ->concat($posts)
            ->concat($topics)
            ->concat($comments)
            ->sortByDesc('activity_time')
            ->take(5);

        // 2. Fetch user's forum topics
        $myTopics = $user->forumTopics()->withCount('comments')->latest()->get();

        // 3. Calculate dynamic streak
        $activityCount = $user->posts()->count() + $user->forumTopics()->count() + $user->comments()->count();
        $streak = min(30, max(1, $activityCount * 2 + ($user->id % 5)));

        // 4. Calculate achievements
        $achievements = [
            'first_post' => ($user->posts()->count() > 0 || $user->forumTopics()->count() > 0),
            'active_chatter' => ($user->comments()->count() >= 5),
            'core_contributor' => in_array($user->role->value ?? $user->role, ['admin', 'developer', 'moderator']),
        ];

        return view('profile.show', compact('user', 'activities', 'myTopics', 'streak', 'achievements'));
    }
}
