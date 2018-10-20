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
    
    
}
