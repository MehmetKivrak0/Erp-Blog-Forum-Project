<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;
use App\Core\Enums\PostStatus;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'active',
        ]);

        $this->user = User::factory()->create([
            'role' => 'user',
            'status' => 'active',
        ]);
    }

    public function test_guest_is_redirected_from_admin_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_regular_user_cannot_access_admin_dashboard(): void
    {
        $this->actingAs($this->user);
        $response = $this->get(route('admin.dashboard'));
        $response->assertStatus(403);
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $this->actingAs($this->admin);
        $response = $this->get(route('admin.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Admin Overview');
    }

    public function test_admin_can_update_user_role(): void
    {
        $this->actingAs($this->admin);
        
        $response = $this->post(route('admin.users.role', $this->user->id), [
            'role' => 'moderator'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'role' => 'moderator'
        ]);
    }

    public function test_admin_can_update_user_status(): void
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.users.status', $this->user->id), [
            'status' => 'suspended'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'status' => 'suspended'
        ]);
    }

    public function test_admin_can_approve_post(): void
    {
        $this->actingAs($this->admin);

        $category = Category::create([
            'name' => 'Backend',
            'slug' => 'backend',
            'type' => 'blog',
        ]);

        $post = Post::create([
            'user_id' => $this->user->id,
            'category_id' => $category->id,
            'title' => 'Test Post Approval',
            'slug' => 'test-post-approval',
            'content' => 'Test content',
            'status' => PostStatus::PENDING->value,
        ]);

        $response = $this->post(route('admin.posts.approve', $post->id));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true
        ]);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'status' => PostStatus::PUBLISHED->value,
        ]);
    }

    public function test_admin_can_reject_post(): void
    {
        $this->actingAs($this->admin);

        $category = Category::create([
            'name' => 'Backend',
            'slug' => 'backend',
            'type' => 'blog',
        ]);

        $post = Post::create([
            'user_id' => $this->user->id,
            'category_id' => $category->id,
            'title' => 'Test Post Rejection',
            'slug' => 'test-post-rejection',
            'content' => 'Test content',
            'status' => PostStatus::PENDING->value,
        ]);

        $response = $this->post(route('admin.posts.reject', $post->id));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true
        ]);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'status' => PostStatus::DRAFT->value,
        ]);
    }

    public function test_admin_can_toggle_maintenance_mode(): void
    {
        $this->actingAs($this->admin);

        // Ensure initially offline
        Cache::forget('maintenance_mode_active');

        $response = $this->post(route('admin.maintenance.toggle'));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'maintenance_active' => true
        ]);

        $this->assertTrue(Cache::get('maintenance_mode_active'));

        // Toggle again
        $response = $this->post(route('admin.maintenance.toggle'));
        $response->assertJson([
            'success' => true,
            'maintenance_active' => false
        ]);
        $this->assertFalse(Cache::get('maintenance_mode_active'));
    }

    public function test_maintenance_mode_blocks_normal_users_but_allows_staff(): void
    {
        // Turn maintenance mode on
        Cache::forever('maintenance_mode_active', true);

        // Guest check
        $response = $this->get(route('home'));
        $response->assertStatus(503);

        // Regular user check
        $this->actingAs($this->user);
        $response = $this->get(route('home'));
        $response->assertStatus(503);

        // Admin check
        $this->actingAs($this->admin);
        $response = $this->get(route('home'));
        $response->assertStatus(200);

        // Clean up
        Cache::forget('maintenance_mode_active');
    }
}
