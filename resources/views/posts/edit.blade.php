@extends('layouts.app')
@section('content')

<div class="container">
<form class="mt-5" action="{{route('posts.update', $post)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="floatingInput" name="title" value="{{old('title', $post->title)}}">
        <label for="floatingInput">Title</label>
        @error('title')
        <div class="alert alert-danger">{{ $message }}</div>
      @enderror
    </div>
    <div class="form-floating">
        <textarea class="form-control" id="floatingTextarea2" style="height: 100px" name="description">{{old('description', $post->description)}}</textarea>
        <label for="floatingTextarea2">Description</label>
        @error('description')
        <div class="alert alert-danger">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3 mt-3">
      <label for="image" class="form-label">Image</label>
      <input type="file" class="form-control" id="image" name="image">
      @if (isset($post->image))
        <img class="mt-3" src="{{asset("images/posts/{$post->image}")}}" width="50" height="50">
      @endif

      @error('image')
        <div class="alert alert-danger">{{ $message }}</div>
      @enderror
    </div>
    <button type="submit" class="btn btn-success mt-3">Edit</button>
</form>
</div>
@endsection