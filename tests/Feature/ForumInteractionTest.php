<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Comment;
use App\Models\ForumTopic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ForumInteractionTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Category $forumCategory;
    private ForumTopic $topic;
    private Comment $reply;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed a basic user
        $this->user = User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com'
        ]);

        // Seed category
        $this->forumCategory = Category::create([
            'name' => 'General DevOps',
            'slug' => 'general-devops',
            'type' => 'forum',
        ]);

        // Seed a topic
        $this->topic = ForumTopic::create([
            'user_id' => $this->user->id,
            'category_id' => $this->forumCategory->id,
            'title' => 'Kubernetes vs Swarm in 2026',
            'slug' => 'kubernetes-vs-swarm-in-2026',
            'content' => 'Which orchestrator is better for startups?',
        ]);

        // Seed a reply
        $this->reply = Comment::create([
            'user_id' => $this->user->id,
            'commentable_id' => $this->topic->id,
            'commentable_type' => ForumTopic::class,
            'content' => 'Swarm is easier but K8s is standard.',
        ]);
    }

    public function test_guest_cannot_vote_or_bookmark(): void
    {
        // Try voting topic
        $response = $this->postJson(route('forum.topic.vote', $this->topic->id), ['value' => 1]);
        $response->assertStatus(401); // Unauthorized for json requests

        // Try voting reply
        $response = $this->postJson(route('forum.reply.vote', $this->reply->id), ['value' => 1]);
        $response->assertStatus(401);

        // Try bookmarking
        $response = $this->postJson(route('forum.topic.bookmark', $this->topic->id));
        $response->assertStatus(401);
    }

    public function test_user_can_upvote_topic(): void
    {
        $this->actingAs($this->user);

        $response = $this->postJson(route('forum.topic.vote', $this->topic->id), ['value' => 1]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'score' => 1,
                'user_vote' => 1,
            ]);

        $this->assertDatabaseHas('votes', [
            'user_id' => $this->user->id,
            'votable_id' => $this->topic->id,
            'votable_type' => ForumTopic::class,
            'value' => 1,
        ]);

        $this->assertEquals(1, $this->topic->fresh()->score);
        $this->assertEquals(1, $this->topic->fresh()->userVoteValue($this->user));
    }

    public function test_user_can_downvote_topic(): void
    {
        $this->actingAs($this->user);

        $response = $this->postJson(route('forum.topic.vote', $this->topic->id), ['value' => -1]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'score' => -1,
                'user_vote' => -1,
            ]);

        $this->assertDatabaseHas('votes', [
            'user_id' => $this->user->id,
            'votable_id' => $this->topic->id,
            'votable_type' => ForumTopic::class,
            'value' => -1,
        ]);

        $this->assertEquals(-1, $this->topic->fresh()->score);
        $this->assertEquals(-1, $this->topic->fresh()->userVoteValue($this->user));
    }

    public function test_user_can_change_and_cancel_vote_on_topic(): void
    {
        $this->actingAs($this->user);

        // 1. Upvote
        $this->postJson(route('forum.topic.vote', $this->topic->id), ['value' => 1])
            ->assertJson(['score' => 1, 'user_vote' => 1]);

        // 2. Switch to Downvote (should decrease score by 2 since it was +1 and now -1)
        $this->postJson(route('forum.topic.vote', $this->topic->id), ['value' => -1])
            ->assertJson(['score' => -1, 'user_vote' => -1]);

        // 3. Cancel vote (value = 0)
        $this->postJson(route('forum.topic.vote', $this->topic->id), ['value' => 0])
            ->assertJson(['score' => 0, 'user_vote' => null]);

        $this->assertDatabaseMissing('votes', [
            'user_id' => $this->user->id,
            'votable_id' => $this->topic->id,
            'votable_type' => ForumTopic::class,
        ]);

        $this->assertEquals(0, $this->topic->fresh()->score);
        $this->assertNull($this->topic->fresh()->userVoteValue($this->user));
    }

    public function test_user_can_vote_comment(): void
    {
        $this->actingAs($this->user);

        // Upvote comment
        $response = $this->postJson(route('forum.reply.vote', $this->reply->id), ['value' => 1]);
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'score' => 1,
                'user_vote' => 1,
            ]);

        $this->assertDatabaseHas('votes', [
            'user_id' => $this->user->id,
            'votable_id' => $this->reply->id,
            'votable_type' => Comment::class,
            'value' => 1,
        ]);

        // Switch to downvote
        $response = $this->postJson(route('forum.reply.vote', $this->reply->id), ['value' => -1]);
        $response->assertJson([
            'score' => -1,
            'user_vote' => -1,
        ]);

        // Cancel
        $response = $this->postJson(route('forum.reply.vote', $this->reply->id), ['value' => 0]);
        $response->assertJson([
            'score' => 0,
            'user_vote' => null,
        ]);

        $this->assertDatabaseMissing('votes', [
            'user_id' => $this->user->id,
            'votable_id' => $this->reply->id,
            'votable_type' => Comment::class,
        ]);
    }

    public function test_user_can_bookmark_topic_toggle(): void
    {
        $this->actingAs($this->user);

        // 1. Bookmark
        $response = $this->postJson(route('forum.topic.bookmark', $this->topic->id));
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'bookmarked' => true,
            ]);

        $this->assertDatabaseHas('bookmarks', [
            'user_id' => $this->user->id,
            'bookmarkable_id' => $this->topic->id,
            'bookmarkable_type' => ForumTopic::class,
        ]);

        $this->assertTrue($this->topic->fresh()->isBookmarkedBy($this->user));

        // 2. Unbookmark
        $response = $this->postJson(route('forum.topic.bookmark', $this->topic->id));
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'bookmarked' => false,
            ]);

        $this->assertDatabaseMissing('bookmarks', [
            'user_id' => $this->user->id,
            'bookmarkable_id' => $this->topic->id,
            'bookmarkable_type' => ForumTopic::class,
        ]);

        $this->assertFalse($this->topic->fresh()->isBookmarkedBy($this->user));
    }
}
