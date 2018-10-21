<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct () {
        $this->middleware('auth')->except(['show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         /*$posts = Post::with(['user' => function($query)
        {
            $query->where('gender', '=',Auth::user()->gender);
        
        }])->orderBy('created_at', 'desc')->paginate(10);*/   // NOT Working Well 
        
        $posts = \DB::table('posts')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->select('posts.*', 'users.name')
            ->where('users.gender',Auth::user()->gender)
            ->orderBy('posts.created_at', 'desc')->get();  //paginate(10);
            
        return $posts;
        //return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:3',
            'body' => 'required|min:10'
        ]);
        Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => Auth::id(),
        ]);
        return redirect(route('home'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('post.edit', compact('post'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();
        session()->flash('message', 'Your post have been updated successfully');
        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Post::destroy($request->id);
        return redirect(route('home'));
    }
}
