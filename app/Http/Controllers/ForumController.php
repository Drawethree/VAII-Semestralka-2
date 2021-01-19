<?php

namespace App\Http\Controllers;

use App\Models\Forum;

class ForumController extends Controller
{
    public
    function show(Forum $forum)
    {
        return view('forum.view', [
            'articles' => $forum->articles()->where('approved', 1)->paginate(5),
            'forum' => $forum
        ]);
    }

    public function createArticle(Forum $forum)
    {
        return view('article.create', [
            'action' => route('article.store'),
            'type' => 'create',
            'method' => 'post',
            'forum' => $forum
        ]);
    }

}
