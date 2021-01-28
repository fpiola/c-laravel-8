
<h1>Posts</h1>
<a href="{{ route('posts.create') }}">Criar novo post</a>
@foreach ($posts as $post)
    <p>{{ $post->title }}</p>
    <p>{{ $post->content }}</p>
@endforeach