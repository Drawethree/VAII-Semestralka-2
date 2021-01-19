<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Forum;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Tracker;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', [
            'forums' => Forum::all(),
            'last_posts'=> Article::orderBy('updated_at', 'desc')->take(5)->get()
        ]);
    }

    public function getBlogStats()
    {
        $usersCount = User::all()->count();
        $articlesCount = Article::all()->count();
        $commentsCount = Comment::all()->count();
        $forumsCount = Forum::all()->count();

        return response()->json(array(
            'userCount' => $usersCount,
            'articlesCount' => $articlesCount,
            'commentsCount' => $commentsCount,
            'forumsCount' => $forumsCount
        ), 200);
    }
}
