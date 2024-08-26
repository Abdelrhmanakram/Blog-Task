@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4 text-primary">Edit Post</h1>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('posts.update', $post->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Specify the HTTP method as PUT for updating --}}

                    <div class="form-group">
                        <label for="title" class="text-secondary">Title</label>
                        <input type="text" name="title" id="title"
                            class="form-control @error('title') is-invalid @enderror"
                            placeholder="Enter post title"
                            value="{{ old('title', $post->title) }}"> {{-- Pre-fill with current title --}}
                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label for="content" class="text-secondary">Content</label>
                        <textarea name="content" id="content" rows="5"
                            class="form-control @error('content') is-invalid @enderror"
                            placeholder="Enter post content">{{ old('content', $post->content) }}</textarea> {{-- Pre-fill with current content --}}
                        @error('content')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-success">Update Post</button>
                        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
