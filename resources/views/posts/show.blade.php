@extends('layouts.app')
@section('content')

<div class="container">
  <div class="card">
    <div class="card-header text-center">
      Post Information
    </div>
    <div class="card-body">
      @if ($post->image)
      <img src="{{asset("images/posts/{$post->image}")}}" width="250" height="200">
      @endif
      <blockquote class="blockquote mb-0">
        <h5 class="card-title">Title:-</h5>
        <p class="card-text">{{$post->title}}</p>
        <h5 class="card-title">Description:-</h5>
        <p class="card-text">{{$post->description}}</p>
        <h5 class="card-title">Posted by:-</h5>
        <p class="card-text">{{$post->creator->name}}</p>
        <h5 class="card-title">Created at:-</h5>
        <p class="card-text">{{ $post->human_readable_date }}</p>
    </div>
  </div>
  <a href="{{route("posts.index")}}" class="btn btn-primary mt-3 mb-5">Back to all Posts </a>
  <div class="container">
    @if ($post->comments->count())
    <h3 class="text-center">Comments</h3>

    @foreach($post->comments as $comment)
    <figure class="text-start">
      <blockquote class="blockquote">
        <p>{{ $comment->content }}</p>
      </blockquote>
      <figcaption class="blockquote-footer">
        Commented by:<cite title="Source Title">{{ $comment->creator->name }} on {{ $comment->created_at->format('d M Y, h:i:S A') }}</cite>
      </figcaption>
    </figure>

    @endforeach
    @else
    <h3 class="text-center">No comments found</h3>
    @endif
  </div>
</div>
@endsection