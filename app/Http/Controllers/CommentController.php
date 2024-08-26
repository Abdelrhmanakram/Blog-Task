<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Mail\NewCommentNotification;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{

    public function index()
    {
        $comments = Comment::all();
        return view('comments.index', compact('comments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:255',
            'post_id' => 'required|exists:posts,id',
        ]);

        $post = Post::findOrFail($request->input('post_id'));

       $comment = Comment::create([
            'content' => $request->input('content'),
            'post_id' => $request->input('post_id'),
            'user_id' => auth()->id(),
        ]);

        // Send email notification to the post author
        $post = $comment->post;
        $author = $post->user;

        Mail::to($author->email)->send(new NewCommentNotification($comment));

        return redirect()->route('posts.show', $post->id);
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            return redirect()->back();
        }

        $comment->delete();

        return redirect()->back();
    }
}
