@extends('layouts.app')
@section("title")
    menambahkan postingan
@endsection
@section("content")

<form action="/book/{{ $post->id }}" method="POST">
    @method("PUT")
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @csrf
    <div class="form-group">
      <label for="title">title</label>
      <input type="text" value="{{old("title", $post->title)}}" class="form-control" id="title" name="title">
    </div>
    <div class="form-group">
        <label for="summary">summary</label>
        <textarea name="summary" type="text"  class="form-control" id="summary"> {{old("summary",$post->summary)}}</textarea>
      </div>

    <div class="form-group">
        <label for="author">author</label>
        <input type="text" value="{{old("author",$post->author)}}" class="form-control" id="author" name="author">
      </div>
      <div class="form-group">
        <label for="release_year">release year</label>
        <input type="text" value="{{old("release_year",$post->release_year)}}" class="form-control" id="release_year" name="release_year">
      </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
@endsection