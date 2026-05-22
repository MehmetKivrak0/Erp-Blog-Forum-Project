<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\ForumTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Core\Enums\UserRole;
use App\Core\Enums\PostStatus;

class AdminController extends Controller
{
    /**
     * Display the Admin Dashboard.
     */
    public function dashboard()
    {
        $users = User::all();
        $totalUsers = User::count();
        $pendingReports = Post::where('status', PostStatus::PENDING->value)->count();
        $activeDiscussions = ForumTopic::count();
        $solutionRate = 94; // Hardcoded or mock metric

        return view('admin.dashboard', compact(
            'users',
            'totalUsers',
            'pendingReports',
            'activeDiscussions',
            'solutionRate'
        ));
    }

    /**
     * Display the Moderator Queue Hub.
     */
    public function moderatorQueue()
    {
        // Fetch real database records
        $pendingPosts = Post::where('status', PostStatus::PENDING->value)->with('user', 'category')->get();
        
        // For simulation, let's treat draft posts as rejected/draft items, and published as resolved
        $flaggedPosts = Post::where('status', PostStatus::DRAFT->value)->with('user', 'category')->get();
        $resolvedPosts = Post::where('status', PostStatus::PUBLISHED->value)->with('user', 'category')->get();

        return view('admin.moderator-queue', compact('pendingPosts', 'flaggedPosts', 'resolvedPosts'));
    }

    /**
     * Display the System Monitor.
     */
    public function systemMonitor()
    {
        $isMaintenanceActive = Cache::get('maintenance_mode_active', false);
        return view('admin.system-monitor', compact('isMaintenanceActive'));
    }

    /**
     * API: Update a user's role.
     */
    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|string|in:admin,moderator,developer,user'
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => "{$user->name} kullanıcısının rolü {$request->role} olarak güncellendi."
        ]);
    }

    /**
     * API: Update a user's status (active/suspended/inactive).
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:active,suspended,inactive'
        ]);

        $user = User::findOrFail($id);
        $user->status = $request->status;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => "{$user->name} kullanıcısının durumu {$request->status} olarak güncellendi."
        ]);
    }

    /**
     * API: Approve a pending blog post.
     */
    public function approvePost($id)
    {
        $post = Post::findOrFail($id);
        $post->status = PostStatus::PUBLISHED->value;
        $post->save();

        return response()->json([
            'success' => true,
            'message' => "'{$post->title}' başlıklı yazı başarıyla onaylandı."
        ]);
    }

    /**
     * API: Reject a pending blog post.
     */
    public function rejectPost($id)
    {
        $post = Post::findOrFail($id);
        $post->status = PostStatus::DRAFT->value;
        $post->save();

        return response()->json([
            'success' => true,
            'message' => "'{$post->title}' başlıklı yazı reddedildi ve taslağa çekildi."
        ]);
    }

    /**
     * API: Toggle site-wide maintenance mode.
     */
    public function toggleMaintenance()
    {
        $currentState = Cache::get('maintenance_mode_active', false);
        $newState = !$currentState;
        
        Cache::forever('maintenance_mode_active', $newState);

        return response()->json([
            'success' => true,
            'maintenance_active' => $newState,
            'message' => $newState 
                ? 'Bakım modu başarıyla aktif edildi. Site genel kullanıma kapatıldı.' 
                : 'Bakım modu başarıyla devre dışı bırakıldı. Site genel kullanıma açıldı.'
        ]);
    }
}
