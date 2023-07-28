<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest; 
use App\Models\Post;
use Cloudinary;
/*
@param Object Post
@return Response post view
*/

class PostController extends Controller
{
    public function index(Post $post)
    {
        return view('posts.index')->with(['posts' => $post->getPaginateByLimit()]);
    }
    
    public function create()
    {
        return view('posts.create');
    }
    
    public function store(PostRequest $request, Post $post)
    {
        $image_url = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
        dd($image_url);
        
        $input = $request['post'];
        $input += ['user_id' => $request->user()->id]; 
        $post->fill($input)->save();
        return redirect('/posts/' . $post->id);
    }

    
    public function show(Post $post)
    {   
        return view('posts.show')->with(['post' => $post]);
    }
    
    public function edit(Post $post)
    {
        return view('posts.edit')->with(['post' => $post]);
    }
    
    public function update(PostRequest $request, Post $post)
    {
        $input_post = $request['post'];
        $input_post += ['user_id' => $request->user()->id];
        $post->fill($input_post)->save();
        return redirect('/posts/' .$post->id);
    }
    

    public function delete(Post $post)
    {
        $post->delete();
        return redirect('/');
    }
    
}

