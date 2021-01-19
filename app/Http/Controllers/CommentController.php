<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public
    function create(Request $request)
    {
        $request->validate([
            'text' => ['required', 'string', 'max:255'],
        ]);

        $comment = Comment::create([
            'text' => request('text'),
            'article_id' => request('article_id'),
            'user_id' => auth()->id()
        ]);


        $comment->save();

        return redirect()->route('article.view', \request('article_id'));
    }

    public function delete(Comment $comment)
    {
        $articleId = $comment->article->id;
        $comment->delete();
        return redirect()->route('article.view', [$articleId]);
    }
}
