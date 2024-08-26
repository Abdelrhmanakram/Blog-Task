@extends('layouts.app')

@section('title', 'Post Details')

@section('content')
<div class="container mt-5">
    <!-- Back to Posts Button -->
    <a href="{{ route('posts.index') }}" class="btn btn-secondary mb-4">Back to Posts</a>

    <h1 class="mb-4 text-primary">{{ $post->title }}</h1>

    <!-- Post Details Table -->
    <div class="card mb-4">
        <div class="card-body">
            <h3 class="text-secondary">Post Details</h3>
            <table class="table table-bordered table-striped">
                <tr>
                    <th scope="col">ID</th>
                    <td>{{ $post->id }}</td>
                </tr>
                <tr>
                    <th scope="col">Title</th>
                    <td>{{ $post->title }}</td>
                </tr>
                <tr>
                    <th scope="col">Content</th>
                    <td>{{ $post->content }}</td>
                </tr>
                <tr>
                    <th scope="col">Author</th>
                    <td>{{ $post->user->name }}</td>
                </tr>
                <tr>
                    <th scope="col">Created At</th>
                    <td>{{ $post->created_at->format('d M Y, h:i A') }}</td>
                </tr>
                <tr>
                    <th scope="col">Updated At</th>
                    <td>{{ $post->updated_at->format('d M Y, h:i A') }}</td>
                </tr>
            </table>

            @auth
                @if($post->user_id === auth()->id())
                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                    </form>
                @endif
            @endauth
        </div>
    </div>

    <!-- Comments Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-secondary">Comments</h3>
        @auth
            <!-- Button to trigger the modal -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#commentModal">
                Add Comment
            </button>
        @endauth
    </div>

    <!-- Comments Table -->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Content</th>
                        <th scope="col">Author</th>
                        <th scope="col">Created At</th>
                        @auth
                            <th scope="col">Actions</th>
                        @endauth
                    </tr>
                </thead>
                <tbody>
                    @foreach($post->comments as $comment)
                        <tr>
                            <td>{{ $comment->id }}</td>
                            <td>{{ $comment->content }}</td>
                            <td>{{ $comment->user->name }}</td>
                            <td>{{ $comment->created_at->format('d M Y, h:i A') }}</td>
                            @auth
                                <td>
                                    @if($comment->user_id === auth()->id())
                                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this comment?')">Delete</button>
                                        </form>
                                    @endif
                                </td>
                            @endauth
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Comment Modal -->
<div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commentModalLabel">Add Comment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">

                    <div class="form-group">
                        <label for="content" class="text-secondary">Comment</label>
                        <textarea name="content" id="content" rows="3" class="form-control @error('content') is-invalid @enderror" placeholder="Enter your comment"></textarea>
                        @error('content')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Submit Comment</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
