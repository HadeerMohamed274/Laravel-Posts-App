@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Comment</h1>
    <form action="{{ route('posts.comment', $post->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="content">Comment:</label>
            <textarea name="content" id="content" rows="4" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Add Comment</button>
    </form>
    <a href="{{ route('posts.index') }}" class="btn btn-secondary mt-3">Back to Posts</a>
</div>
@endsection