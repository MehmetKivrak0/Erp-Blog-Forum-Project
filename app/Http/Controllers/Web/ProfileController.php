<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        /** @var \App\Models\User $user */
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

        // 3. Get real streak
        $streak = $user->current_streak ?? 0;

        // 4. Fetch achievements
        $userAchievements = $user->achievements->keyBy('key');
        $allAchievements = \App\Models\Achievement::all();

        $achievements = [
            'first_post' => $userAchievements->has('first_post'),
            'active_chatter' => $userAchievements->has('active_chatter'),
            'core_contributor' => $userAchievements->has('core_contributor') || in_array($user->role->value ?? $user->role, ['admin', 'developer', 'moderator']),
        ];

        return view('profile.show', compact('user', 'activities', 'myTopics', 'streak', 'achievements', 'allAchievements', 'userAchievements'));
    }
}
