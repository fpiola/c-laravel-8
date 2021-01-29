<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdatePost;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        //$posts = Post::all();
        //dd($posts);

        //$posts = Post::paginate(1);

        $posts = Post::orderBy('id', 'ASC')->paginate(1);

        return view('admin.posts.index', compact('posts'));
        //return view('admin.posts.index', ['posts' => $posts]);
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(StoreUpdatePost $request)
    {
        //$requeste = new Request();
        //dd($requeste->title); //Título
        //dd($requeste->all()); //Todos

        //Inserir no banco de dados
        Post::create($request->all());
        //(Importante) colocar o fillable no model Post

        //return 'Okay';
        return redirect()
            ->route('posts.index')
            ->with('message', 'Post Cadastrado com Sucesso');
    }

    public function show($id)
    {
        //$post = Post::where('id', $id)->first();
        $post = Post::find($id);
        if (!$post) {
            return redirect()->route('posts.index');
        }
        return view('admin.posts.show', compact('post'));
    }

    public function destroy($id)
    {
        //dd($id);
        $post = Post::find($id);
        if (!$post) {
            return redirect()->route('posts.index');
        }
        $post->delete();
        return redirect()->route('posts.index')
            ->with('message', 'Post Deletado com Sucesso');
    }

    public function edit($id)
    {
        //$post = Post::where('id', $id)->first();
        $post = Post::find($id);
        if (!$post) {
            return redirect()->back();
        }
        return view('admin.posts.edit', compact('post'));
    }

    public function update($id, StoreUpdatePost $request)
    {
        //$post = Post::where('id', $id)->first();
        $post = Post::find($id);
        if (!$post) {
            return redirect()->back();
        }

        $post->update($request->all());

        return redirect()->route('posts.index')
            ->with('message', 'Post Editado com Sucesso');
    }

    public function search(Request $request)
    {
        //dd("Pesquisando por {{$request->search}}");

        $filters = $request->except('_token');

        $posts = Post::where('title', 'LIKE', "%{$request->search}%")
            ->orWhere('content', 'LIKE', "%{$request->search}%")
            ->paginate(1);

        return view('admin.posts.index', compact('posts', 'filters'));
    }
}
