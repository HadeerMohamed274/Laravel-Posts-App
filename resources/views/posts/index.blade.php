@extends('layouts.app')
@section('content')

<div class="container">
  @if(session('success'))
  <div class="alert alert-success">
    {!! session('success') !!}
  </div>
  @endif
  <h1 class="text-center">All Posts</h1>
  <a class="btn btn-success mb-3 mt-5 container" href="{{route('posts.create')}}">Create</a>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Title</th>
        <th scope="col">Slug</th>
        <th scope="col">Posted by</th>
        <th scope="col">Created at</th>
        <th scope="col">View</th>
        <th scope="col">Edit</th>
        <th scope="col">Comment</th>
        <th scope="col">Delete</th>
      </tr>
    </thead>
    <tbody>

      @foreach ($posts as $post)
      <tr>
        <td>{{$post->id}}</td>
        <td>{{$post->title}}</td>
        <td>{{$post->slug}}</td>
        <td>{{$post->creator->name}}</td>
        <td>{{ \Carbon\Carbon::parse($post->created_at)->format('Y-m-d') }}</td>
        <td><a class="btn btn-primary" href="{{route('posts.show', $post['id'])}}">View</a></td>
        <td><a class="btn btn-info" href="{{route('posts.edit', $post['id'])}}">Edit</a></td>
        <td><a class="btn btn-warning" href="{{ route('posts.comment.form', $post['id']) }}">Add Comment</a></td>
        <td>
          <form action="{{route('posts.destroy', $post['id'])}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach

    </tbody>
  </table>

  {{$posts->links()}}
</div>
@endsection