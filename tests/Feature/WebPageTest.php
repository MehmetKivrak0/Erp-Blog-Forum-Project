<?php

namespace Tests\Feature;

use App\Core\Enums\PostStatus;
use App\Models\Category;
use App\Models\Comment;
use App\Models\ForumTopic;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebPageTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Category $blogCategory;
    private Category $forumCategory;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed a basic user
        $this->user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ]);

        // Seed categories
        $this->blogCategory = Category::create([
            'name' => 'Backend Development',
            'slug' => 'backend-development',
            'type' => 'blog',
        ]);

        $this->forumCategory = Category::create([
            'name' => 'DevOps',
            'slug' => 'devops',
            'type' => 'forum',
        ]);
    }

    public function test_homepage_displays_dynamic_data(): void
    {
        // Create posts & forum topics
        $post = Post::create([
            'user_id' => $this->user->id,
            'category_id' => $this->blogCategory->id,
            'title' => 'Scaling Laravel APIs',
            'slug' => 'scaling-laravel-apis',
            'content' => 'This is a test post about scaling Laravel.',
            'status' => PostStatus::PUBLISHED,
        ]);

        $topic = ForumTopic::create([
            'user_id' => $this->user->id,
            'category_id' => $this->forumCategory->id,
            'title' => 'Docker vs Podman in 2026',
            'slug' => 'docker-vs-podman-in-2026',
            'content' => 'Which container engine should we choose for production?',
        ]);

        // Create comment for activity
        Comment::create([
            'user_id' => $this->user->id,
            'commentable_id' => $post->id,
            'commentable_type' => Post::class,
            'content' => 'Great write-up!',
        ]);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Scaling Laravel APIs');
        $response->assertSee('Docker vs Podman in 2026');
        $response->assertSee('John Doe');
        $response->assertSee('1'); // total members
        $response->assertSee('1'); // active discussions
    }

    public function test_blog_details_page(): void
    {
        $post = Post::create([
            'user_id' => $this->user->id,
            'category_id' => $this->blogCategory->id,
            'title' => 'Building Clean Architecture',
            'slug' => 'building-clean-architecture',
            'content' => 'Clean architecture is key.',
            'status' => PostStatus::PUBLISHED,
        ]);

        Comment::create([
            'user_id' => $this->user->id,
            'commentable_id' => $post->id,
            'commentable_type' => Post::class,
            'content' => 'Very insightful post!',
        ]);

        $response = $this->get(route('blog.show', $post->id));

        $response->assertStatus(200);
        $response->assertSee('Building Clean Architecture');
        $response->assertSee('Clean architecture is key.');
        $response->assertSee('Very insightful post!');
    }

    public function test_forum_thread_page(): void
    {
        $topic = ForumTopic::create([
            'user_id' => $this->user->id,
            'category_id' => $this->forumCategory->id,
            'title' => 'Kubernetes Clustering Tutorial',
            'slug' => 'kubernetes-clustering-tutorial',
            'content' => 'Here is how to set up K8s cluster.',
        ]);

        Comment::create([
            'user_id' => $this->user->id,
            'commentable_id' => $topic->id,
            'commentable_type' => ForumTopic::class,
            'content' => 'Use K3s for lightweight environments.',
        ]);

        $response = $this->get(route('forum.thread', $topic->id));

        $response->assertStatus(200);
        $response->assertSee('Kubernetes Clustering Tutorial');
        $response->assertSee('Here is how to set up K8s cluster.');
        $response->assertSee('Use K3s for lightweight environments.');
        $response->assertSee('Verified Solution'); // Since it's the first response, it gets marked as verified
    }

    public function test_blog_create_page_redirects_guest(): void
    {
        $response = $this->get(route('blog.create'));
        $response->assertRedirect(route('login'));
    }

    public function test_blog_create_page_accessible_by_authenticated_user(): void
    {
        $this->actingAs($this->user);
        $response = $this->get(route('blog.create'));

        $response->assertStatus(200);
        $response->assertSee('Backend Development'); // category name
    }

    public function test_blog_post_creation_stores_data(): void
    {
        // Act as user (we'll just use authentication mock or let the controller handle default user)
        $this->actingAs($this->user);

        $response = $this->post(route('blog.create.post'), [
            'title' => 'My Brand New Blog Post',
            'content' => 'Some technical content about PHP.',
            'category_id' => $this->blogCategory->id,
            'visibility' => 'public',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('posts', [
            'title' => 'My Brand New Blog Post',
            'category_id' => $this->blogCategory->id,
        ]);
    }

    public function test_store_comment_on_blog(): void
    {
        $this->actingAs($this->user);

        $post = Post::create([
            'user_id' => $this->user->id,
            'category_id' => $this->blogCategory->id,
            'title' => 'Yet Another Post',
            'slug' => 'yet-another-post',
            'content' => 'Post content goes here.',
            'status' => PostStatus::PUBLISHED,
        ]);

        $response = $this->post(route('blog.comment', $post->id), [
            'comment' => 'This is a test comment.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('comments', [
            'content' => 'This is a test comment.',
            'commentable_id' => $post->id,
            'commentable_type' => Post::class,
        ]);
    }

    public function test_reply_to_forum_thread(): void
    {
        $this->actingAs($this->user);

        $topic = ForumTopic::create([
            'user_id' => $this->user->id,
            'category_id' => $this->forumCategory->id,
            'title' => 'A Thread to Reply To',
            'slug' => 'a-thread-to-reply-to',
            'content' => 'Is anyone there?',
        ]);

        $response = $this->post(route('forum.reply', $topic->id), [
            'reply' => 'Yes, I am here answering.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('comments', [
            'content' => 'Yes, I am here answering.',
            'commentable_id' => $topic->id,
            'commentable_type' => ForumTopic::class,
        ]);
    }

    public function test_blog_index_page(): void
    {
        $post = Post::create([
            'user_id' => $this->user->id,
            'category_id' => $this->blogCategory->id,
            'title' => 'Building Clean Architecture',
            'slug' => 'building-clean-architecture',
            'content' => 'Clean architecture is key.',
            'status' => PostStatus::PUBLISHED,
        ]);

        $response = $this->get(route('blog.index'));

        $response->assertStatus(200);
        $response->assertSee('Building Clean Architecture');
    }

    public function test_blog_index_filters_by_category(): void
    {
        $otherCategory = Category::create([
            'name' => 'Frontend Development',
            'slug' => 'frontend-development',
            'type' => 'blog',
        ]);

        $post1 = Post::create([
            'user_id' => $this->user->id,
            'category_id' => $this->blogCategory->id,
            'title' => 'Backend Stuff',
            'slug' => 'backend-stuff',
            'content' => 'Content.',
            'status' => PostStatus::PUBLISHED,
        ]);

        $post2 = Post::create([
            'user_id' => $this->user->id,
            'category_id' => $otherCategory->id,
            'title' => 'Frontend Stuff',
            'slug' => 'frontend-stuff',
            'content' => 'Content.',
            'status' => PostStatus::PUBLISHED,
        ]);

        $response = $this->get(route('blog.index', ['category' => 'backend-development']));
        $response->assertStatus(200);
        $response->assertSee('Backend Stuff');
        $response->assertDontSee('Frontend Stuff');

        $response2 = $this->get(route('blog.index', ['category' => 'frontend-development']));
        $response2->assertStatus(200);
        $response2->assertSee('Frontend Stuff');
        $response2->assertDontSee('Backend Stuff');
    }

    public function test_forum_index_page(): void
    {
        $topic = ForumTopic::create([
            'user_id' => $this->user->id,
            'category_id' => $this->forumCategory->id,
            'title' => 'Kubernetes Clustering Tutorial',
            'slug' => 'kubernetes-clustering-tutorial',
            'content' => 'Here is how to set up K8s cluster.',
        ]);

        $response = $this->get(route('forum.index'));

        $response->assertStatus(200);
        $response->assertSee('Kubernetes Clustering Tutorial');
    }

    public function test_forum_index_filters_by_category(): void
    {
        $otherCategory = Category::create([
            'name' => 'General Topic',
            'slug' => 'general-topic',
            'type' => 'forum',
        ]);

        $topic1 = ForumTopic::create([
            'user_id' => $this->user->id,
            'category_id' => $this->forumCategory->id,
            'title' => 'DevOps Chat',
            'slug' => 'devops-chat',
            'content' => 'Content.',
        ]);

        $topic2 = ForumTopic::create([
            'user_id' => $this->user->id,
            'category_id' => $otherCategory->id,
            'title' => 'General Chat',
            'slug' => 'general-chat',
            'content' => 'Content.',
        ]);

        $response = $this->get(route('forum.index', ['category' => 'devops']));
        $response->assertStatus(200);
        $response->assertSee('DevOps Chat');
        $response->assertDontSee('General Chat');

        $response2 = $this->get(route('forum.index', ['category' => 'general-topic']));
        $response2->assertStatus(200);
        $response2->assertSee('General Chat');
        $response2->assertDontSee('DevOps Chat');
    }

    public function test_profile_page_redirects_guest(): void
    {
        $response = $this->get(route('profile'));
        $response->assertRedirect(route('login'));
    }

    public function test_profile_page_displays_real_activities(): void
    {
        $this->actingAs($this->user);

        $post = Post::create([
            'user_id' => $this->user->id,
            'category_id' => $this->blogCategory->id,
            'title' => 'My Personal Secret Post',
            'slug' => 'my-personal-secret-post',
            'content' => 'Content here.',
            'status' => PostStatus::PUBLISHED,
        ]);

        $comment = Comment::create([
            'user_id' => $this->user->id,
            'commentable_id' => $post->id,
            'commentable_type' => Post::class,
            'content' => 'My Secret Comment content',
        ]);

        $response = $this->get(route('profile'));
        $response->assertStatus(200);
        $response->assertSee('My Personal Secret Post');
        $response->assertSee('My Secret Comment content');
        $response->assertSee($this->user->name);
    }

    public function test_profile_page_displays_warning_if_suspended(): void
    {
        $suspendedUser = User::factory()->create([
            'name' => 'Bad Guy',
            'email' => 'bad@example.com',
            'status' => 'suspended',
        ]);

        $this->actingAs($suspendedUser);

        $response = $this->get(route('profile'));
        $response->assertStatus(200);
        $response->assertSee('Hesap Askıya Alındı');
    }
}
