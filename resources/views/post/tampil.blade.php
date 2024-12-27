@extends('layouts.app')
@section("title")
    tambah postingan
@endsection
@section("content")

<a href="/book/create" class="btn btn-primary btn-sm">Tambah Book</a>

<table class="table">
    <thead>
      <tr>
        <th scope="col">id</th>
        <th scope="col">title</th>
        <th scope="col">summary</th>
        <th scope="col">author</th>
        <th scope="col">release year</th>
        <th scope="col">action</th>
      </tr>
    </thead>
    <tbody>
    @forelse ($books as $item)
    <tr>
        <th scope="row">{{$loop->iteration}}</th>
        <td>{{ $item->title }}</td>
        <td>{{ $item->summary }}</td>
        <td>{{ $item->author }}</td>
        <td>{{ $item->release_year }}</td>
        <td>
            <form action="book/{{ $item->id }}" method="POST">
                @method("delete")
                @csrf
                <a href="/book{{ $item->id }}" class="btn btn-info btn-sm">detail</a>
                <a href="/book/{{ $item->id }}/edit" class="btn btn-warning btn-sm">edit</a>
                <button type="submit" class="btn btn-danger btn-sm">delete</button>
            </form>
        </td>
      </tr>
        @empty
        <p>No users</p>
    @endforelse
      
    </tbody>
  </table>

@endsection