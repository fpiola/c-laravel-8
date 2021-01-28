<h1>Cadastrar novo post</h1>
<form action="{{ route('posts.store') }}" method="post">
    @csrf
    <input type="text" name="title" id="title" placeholder="titulo">
    <textarea name="content" id="content" cols="30" rows="4" placeholder="conteudo"></textarea>
    <button type="submit">Enviar</button>
</form>