<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Session;

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
            'articles' => Article::where('approved', 1)->paginate(5)
        ]);
    }

    public function getBlogStats()
    {
        $usersCount = User::all()->count();
        $articlesCount = Article::all()->count();
        $commentsCount = Comment::all()->count();

        return response()->json(array(
            'userCount' => $usersCount,
            'articlesCount' => $articlesCount,
            'commentsCount' => $commentsCount
        ), 200);
    }
}
