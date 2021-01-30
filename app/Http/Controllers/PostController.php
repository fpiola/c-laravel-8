<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdatePost;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        //$request = new Request();
        //dd($request->title); //Título
        //dd($request->all()); //Todos

        //Inserir no banco de dados
        //Post::create($request->all());
        //(Importante) colocar o fillable no model Post

        //Upload
        $data = $request->all();

        if ($request->image->isValid()) {

            $nameFile = Str::of($request->title)->slug('-') . '.' . $request->image->getClientOriginalExtension();

            //$image = $request->image->storeAs('posts', $nameFile);

            $image = Str::substr($request->image->storeAs('public/posts', $nameFile), 7);

            $data['image'] = $image;
        }

        Post::create($data);


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

        if (Storage::exists('public/'.$post->image)) {
            Storage::delete('public/'.$post->image);
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

        $data = $request->all();

        if ($request->image && $request->image->isValid()) {

            if (Storage::exists('public/'.$post->image)) {
                Storage::delete('public/'.$post->image);
            }

            $nameFile = Str::of($request->title)->slug('-') . '.' . $request->image->getClientOriginalExtension();

            //$image = $request->image->storeAs('posts', $nameFile);

            $image = Str::substr($request->image->storeAs('public/posts', $nameFile), 7);

            $data['image'] = $image;
        }


        $post->update($data);

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
