<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if an authenticated user can create a comment.
     */
    public function test_user_can_create_comment()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('comments.store'), [
            'content' => 'This is a test comment.',
            'post_id' => $post->id,
        ]);

        $response->assertRedirect(route('posts.show', $post->id));

        $this->assertDatabaseHas('comments', [
            'content' => 'This is a test comment.',
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
    }


    /**
     * Test if an authenticated user can delete their own comment.
     */
    public function test_user_can_delete_own_comment()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $user->id, 'post_id' => $post->id]);

        $this->actingAs($user);

        $response = $this->delete(route('comments.destroy', $comment->id));

        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
        ]);
    }


    /**
     * Test if an authenticated user cannot delete someone else's comment.
     */
    public function test_user_cannot_delete_another_users_comment()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $post = Post::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $otherUser->id, 'post_id' => $post->id]);

        $this->actingAs($user);

        $response = $this->delete(route('comments.destroy', $comment->id));

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
        ]);
    }
}
