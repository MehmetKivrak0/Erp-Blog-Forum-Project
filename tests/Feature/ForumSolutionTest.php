<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Comment;
use App\Models\ForumTopic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ForumSolutionTest extends TestCase
{
    use RefreshDatabase;

    private User $author;
    private User $nonAuthor;
    private User $admin;
    private Category $forumCategory;
    private ForumTopic $topic;
    private Comment $comment;

    protected function setUp(): void
    {
        parent::setUp();

        $this->author = User::factory()->create(['name' => 'Topic Author']);
        $this->nonAuthor = User::factory()->create(['name' => 'Regular User']);
        $this->admin = User::factory()->create([
            'name' => 'Admin User',
            'role' => 'admin',
        ]);

        $this->forumCategory = Category::create([
            'name' => 'DevOps',
            'slug' => 'devops',
            'type' => 'forum',
        ]);

        $this->topic = ForumTopic::create([
            'user_id' => $this->author->id,
            'category_id' => $this->forumCategory->id,
            'title' => 'Topic Title',
            'content' => 'Topic content',
        ]);

        $this->comment = Comment::create([
            'user_id' => $this->nonAuthor->id,
            'commentable_id' => $this->topic->id,
            'commentable_type' => ForumTopic::class,
            'content' => 'This is a solution reply',
        ]);
    }

    public function test_guest_cannot_toggle_solution(): void
    {
        $response = $this->postJson(route('forum.topic.solution', $this->topic->id), [
            'comment_id' => $this->comment->id,
        ]);

        $response->assertStatus(401);
        $this->assertNull($this->topic->fresh()->solution_comment_id);
    }

    public function test_non_author_cannot_toggle_solution(): void
    {
        $this->actingAs($this->nonAuthor);

        $response = $this->postJson(route('forum.topic.solution', $this->topic->id), [
            'comment_id' => $this->comment->id,
        ]);

        $response->assertStatus(403);
        $this->assertNull($this->topic->fresh()->solution_comment_id);
    }

    public function test_author_can_select_and_deselect_solution(): void
    {
        $this->actingAs($this->author);

        // Select solution
        $response = $this->postJson(route('forum.topic.solution', $this->topic->id), [
            'comment_id' => $this->comment->id,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'solution_comment_id' => $this->comment->id,
            ]);

        $this->assertEquals($this->comment->id, $this->topic->fresh()->solution_comment_id);

        // Deselect solution (toggle off)
        $response = $this->postJson(route('forum.topic.solution', $this->topic->id), [
            'comment_id' => $this->comment->id,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'solution_comment_id' => null,
            ]);

        $this->assertNull($this->topic->fresh()->solution_comment_id);
    }

    public function test_staff_can_toggle_solution(): void
    {
        $this->actingAs($this->admin);

        // Select
        $response = $this->postJson(route('forum.topic.solution', $this->topic->id), [
            'comment_id' => $this->comment->id,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'solution_comment_id' => $this->comment->id,
            ]);

        $this->assertEquals($this->comment->id, $this->topic->fresh()->solution_comment_id);
    }

    public function test_cannot_select_comment_from_different_topic(): void
    {
        $otherTopic = ForumTopic::create([
            'user_id' => $this->author->id,
            'category_id' => $this->forumCategory->id,
            'title' => 'Other Topic',
            'content' => 'Other content',
        ]);

        $otherComment = Comment::create([
            'user_id' => $this->nonAuthor->id,
            'commentable_id' => $otherTopic->id,
            'commentable_type' => ForumTopic::class,
            'content' => 'Comment on other topic',
        ]);

        $this->actingAs($this->author);

        // Attempting to mark otherComment as solution for $this->topic
        $response = $this->postJson(route('forum.topic.solution', $this->topic->id), [
            'comment_id' => $otherComment->id,
        ]);

        $response->assertStatus(404);
        $this->assertNull($this->topic->fresh()->solution_comment_id);
    }
}
