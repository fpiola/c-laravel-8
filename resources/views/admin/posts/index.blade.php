@extends('admin.layouts.app')

@section('title','Listagem dos Posts')

@section('content')
    <h1>Posts</h1>
    <a href="{{ route('posts.create') }}">Criar novo post</a>
    <hr>

    @if (session('message'))
        <div>{{ session('message') }}</div>
    @endif


    <form action="{{ route('posts.search') }}" method="post">
        @csrf
        <input type="text" name="search" placeholder="Pesquisar">
        <button type="submit">Enviar</button>
    </form>

    @foreach ($posts as $post)
        <p>
            <img src="{{ url("storage/{$post->image}") }}" alt="{{ $post->title }}" width="100px">
            {{ $post->title  }} 
            <a href="{{ route('posts.show', $post->id) }}">Ver</a> |
            <a href="{{ route('posts.edit', $post->id) }}">Editar</a>
        </p>
    @endforeach

    <hr>
    @if (isset($filters))
        {{ $posts->appends($filters)->links() }}
    @else
        {{ $posts->links() }}
    @endif
@endsection