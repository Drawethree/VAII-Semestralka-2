<?php

namespace App\Http\Controllers;

use Aginev\Datagrid\Datagrid;
use App\Models\Article;
use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $articles = Article::paginate(5);
        $notApprovedCount = Article::where('approved', 0)->get()->count();

        $datagrid = new Datagrid($articles, $request->get('f', []));

        $datagrid->setColumn('user_id', 'User', [
            'wrapper' => function ($value, $row) {
                return $row->user->username;
            }
        ])
            ->setColumn('title', 'Post title')
            ->setColumn('text', 'Text')
            ->setColumn('created_at', 'Created At', [
                'wrapper' => function ($value, $row) {
                    return $value;
                }
            ])
            ->setColumn('forum', 'Forum', [
                'wrapper' => function ($value, $row) {
                    return '<a href="' . route('forum.view', $value->id) . '">' . $value->title . '</a>';
                }
            ])
            ->setActionColumn(['wrapper' => function ($value, $row) {
                $returnVal = '
                    <a class="btn btn-sm btn-warning" href="' . route('article.view', [$row->id]) . '" title="View"><i class="fa fa-eye">&nbsp;</i>View</a>
                    <a class="btn btn-sm btn-primary" href="' . route('article.edit', [$row->id]) . '" title="Edit"><i class="fa fa-edit">&nbsp;</i>Edit</a>
                    <a class="btn btn-sm btn-danger" onclick=" return confirm(\'Are you sure?\') " href="' . route('article.delete', [$row->id]) . '" title="Delete"><i class="fa fa-trash">&nbsp;</i>Delete</a>';

                if ($row->approved == 0) {
                    $returnVal .= ' <a class="btn btn-sm btn-success" href="' . route('article.approve', [$row->id]) . '" title="Approve"><i class="fa fa-check">&nbsp;</i>Approve</a>';
                }
                return $returnVal;

            }]);

        return view('article.index', [
            'grid' => $datagrid,
            'articles' => $articles,
            'not_approved' => $notApprovedCount
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public
    function create(Forum $forum)
    {
        return view('article.create', [
            'action' => route('article.store'),
            'type' => 'create',
            'method' => 'post',
            'forum' => $forum
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public
    function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'text' => ['required', 'string'],
        ]);

        $data = [];
        $data['text'] = request('text');
        $data['title'] = request('title');
        $data['approved'] = 0;
        $data['forum_id'] = request('forum_id');
        $data['user_id'] = auth()->id();

        $article = Article::create($data);

        $article->save();

        if (Auth::user()->getIsAdminAttribute()) {
            Session::flash('status', 'Article ' . $article->id . ' was edited!');
            return redirect()->route('article.index');
        } else {
            Session::flash('status', 'Your article was created! Please wait until admin approves it.');
            return redirect()->route('forum.view', $data['forum_id']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public
    function show(Article $article)
    {
        return view('article.view', [
            'article' => $article
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public
    function edit(Article $article)
    {
        return view('article.edit', [
            'action' => route('article.update', $article->id),
            'method' => 'put',
            'type' => 'edit',
            'model' => $article
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public
    function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'text' => ['required', 'string'],
        ]);

        $article->update([
            'title' => request('title'),
            'text' => request('text')
        ]);

        Session::flash('status', 'Article ' . $article->id . ' was updated!');

        return redirect()->route('article.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public
    function destroy(Article $article)
    {
        $article->delete();
        $article->comments()->delete();
        Session::flash('status', 'Article ' . $article->id . ' was deleted!');

        return redirect()->route('article.index');

    }

    public
    function approve(Article $article)
    {
        $article->approved = 1;
        $article->save();
        Session::flash('status', 'Article ' . $article->id . ' was approved!');

        return redirect()->route('article.index');
    }

    public function approveAll()
    {
        $articles = Article::where('approved', 0)->get();

        foreach ($articles as $article) {
            $article->approved = 1;
            $article->save();
        }

        Session::flash('status', 'All articles were approved!');

        return redirect()->route('article.index');
    }
}
