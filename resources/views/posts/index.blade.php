@extends('layouts.app')

@section('title', 'All Posts')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">All Posts</h1>
        @auth
            <a href="{{ route('posts.create') }}" class="btn btn-success">
                Create New Post
            </a>
        @endauth
    </div>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Title</th>
                <th scope="col">Content</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>
                        <a href="{{ route('posts.show', $post->id) }}" class="text-info">
                            {{ $post->title }}
                        </a>
                    </td>
                    <td>{{ Str::limit($post->content, 100) }}</td>
                    <td>
                        @auth
                            @if($post->user_id === auth()->id())
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-warning">
                                    Edit
                                </a>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
