@extends('layouts.app')
@section("title")
    details postingan
@endsection
@section("content")

<h1>{{ $post->author }}</h1>
{{-- <span class="badge badge-secondary">{{ $post->summary }}</span> --}}
<h2>{{ $post->title }}</h2>
<p>{{ $post->summary }}</p>
<p>{{ $post->release_year }}</p>


<a href="/book" class="btn btn-secondary btn-sm">kembali</a>
@endsection