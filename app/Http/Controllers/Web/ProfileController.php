<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show($id = null)
    {
        $authUser = auth()->user();
        $isOwnProfile = false;

        if ($id && $id != $authUser->id) {
            $user = \App\Models\User::findOrFail($id);
        } else {
            /** @var \App\Models\User $user */
            $user = $authUser;
            $isOwnProfile = true;
        }

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

        return view('profile.show', compact('user', 'activities', 'myTopics', 'streak', 'achievements', 'allAchievements', 'userAchievements', 'isOwnProfile'));
    }

    public function updateImages(Request $request)
    {
        $request->validate([
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        /** @var \App\Models\User $user */
        $user = auth()->user();

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = '/storage/' . $path;
        }

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
            $user->cover_image = '/storage/' . $path;
        }

        $user->save();

        return back()->with('success', 'Profile images updated successfully.');
    }
}
