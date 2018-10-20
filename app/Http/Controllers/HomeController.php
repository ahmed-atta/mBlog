<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
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
            ->orderBy('posts.created_at', 'desc')->paginate(10);


        return view('home', ['posts' => $posts]);
    }
}
