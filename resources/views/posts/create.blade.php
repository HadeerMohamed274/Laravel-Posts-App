@extends('layouts.app')
@section('content')

<div class="container">
  <form class="mt-5" action="{{route('posts.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-floating mb-3">
      <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{old('title')}}" id="floatingInput">

      <label for="floatingInput">Title</label>

      @error('title')
      <div class="alert alert-danger mt-2">{{ $message }}</div>
      @enderror
    </div>

    <div class="form-floating">
      <textarea class="form-control @error('title') is-invalid @enderror" id="floatingTextarea2" style="height: 100px" name="description">{{old('description')}}</textarea>
      <label for="floatingTextarea2">Description</label>
      @error('description')
      <div class="alert alert-danger mt-2">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="image" class="form-label">Image</label>
      <input type="file" class="form-control" value="{{old('image')}}" id="image" name="image">
      @if (isset($post->image))
      <img src="{{asset("images/posts/{$post->image}")}}" width="50" height="50">
      @endif

      @error('image')
      <div class="alert alert-danger">{{ $message }}</div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="creator_id" class="form-label">Post Creator</label>
      <select name="creator_id" id="creator_id">
        @foreach($creators as $creator)
        <option value="{{$creator->id}}" {{ old('creator_id') == $creator ? 'selected' : '' }}>{{$creator->name}}</option>
        @endforeach
      </select>
      @error('creator_id')
      <div class="alert alert-danger">{{ $message }}</div>
      @enderror
    </div>
    <button type="submit" class="btn btn-success mt-3">Create</button>
  </form>
</div>
@endsection