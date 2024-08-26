<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if an authenticated user can create a post.
     */
    public function test_user_can_create_post()
    {
        $user = User::factory()->create(); // Create a test user

        $this->actingAs($user); // Act as the created user

        $response = $this->post(route('posts.store'), [
            'title' => 'Test Post',
            'content' => 'This is a test post content.',
        ]);

        $response->assertRedirect(route('posts.index')); // Assert that it redirects after creation
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
            'content' => 'This is a test post content.',
            'user_id' => $user->id,
        ]);
    }

    /**
     * Test if an authenticated user can update their own post.
     */
    public function test_user_can_update_own_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->put(route('posts.update', $post->id), [
            'title' => 'Updated Title',
            'content' => 'Updated content.',
        ]);

        $response->assertRedirect(route('posts.show', $post->id));
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
            'content' => 'Updated content.',
        ]);
    }

    /**
     * Test if an authenticated user can delete their own post.
     */
    public function test_user_can_delete_own_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->delete(route('posts.destroy', $post->id));

        $response->assertRedirect(route('posts.index'));
        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }


    /**
     * Test if an authenticated user cannot delete someone else's post.
     */
    public function test_user_cannot_delete_another_users_post()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $otherUser->id]);

        $this->actingAs($user);

        $response = $this->delete(route('posts.destroy', $post->id));

        $response->assertRedirect(route('posts.index'));
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
        ]);
    }

    /**
     * Test if an authenticated user cannot update someone else's post.
     */
    public function test_user_cannot_update_another_users_post()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $otherUser->id]);

        $this->actingAs($user);

        $response = $this->put(route('posts.update', $post->id), [
            'title' => 'Updated Title',
            'content' => 'Updated content.',
        ]);

        $response->assertRedirect(route('posts.index'));
        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
            'content' => 'Updated content.',
        ]);
    }

}
