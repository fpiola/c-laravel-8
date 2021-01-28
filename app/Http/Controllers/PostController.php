<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdatePost;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        $posts = Post::all();
        //dd($posts);
        return view('admin.posts.index', compact('posts'));
        //return view('admin.posts.index', ['posts' => $posts]);
    }

    public function create(){
        return view('admin.posts.create');
    }

    public function store(StoreUpdatePost $request){
        //$requeste = new Request();
        //dd($requeste->title); //Título
        //dd($requeste->all()); //Todos

        //Inserir no banco de dados
        Post::create($request->all());
        //(Importante) colocar o fillable no model Post

        //return 'Okay';
        return redirect()->route('posts.index');

    }
}
