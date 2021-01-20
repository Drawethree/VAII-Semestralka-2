<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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

        $article = Article::find(request('article_id'))->first();

        return redirect()->route('article.view', [$article->forum, $article]);
    }

    public function delete(Forum $forum, Article $article, Comment $comment)
    {
        $comment->delete();

        Session::flash('status', 'Comment successfully removed!');

        return redirect()->route('article.view', [$forum, $article]);
    }
}
