<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Forum;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public
    function show(Forum $forum)
    {
        return view('forum.view', [
            'articles' => $forum->articles()->where('approved', 1)->paginate(5)
        ]);
    }
}
