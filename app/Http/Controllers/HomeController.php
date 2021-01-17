<?php

namespace App\Http\Controllers;

use App\Models\Article;

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
}
