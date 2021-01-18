<?php

namespace App\Http\Controllers;

use Aginev\Datagrid\Datagrid;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $articles = Article::paginate(10);

        $datagrid = new Datagrid($articles, $request->get('f', []));

        $datagrid->setColumn('user_id', 'Username', [
            'wrapper' => function ($value, $row) {
                return $row->user->username;
            }
        ])
            ->setColumn('title', 'Title')
            ->setColumn('text', 'Text')
            ->setColumn('created_at', 'Created At', [
                'wrapper' => function ($value, $row) {
                    return $value;
                }
            ])
            ->setActionColumn(['wrapper' => function ($value, $row) {
                $returnVal = '
                    <a class="btn btn-sm btn-primary" href="' . route('article.edit', [$row->id]) . '" title="Edit">Edit</a>
                    <a class="btn btn-sm btn-danger" onclick=" return confirm(\'Are you sure?\') " href="' . route('article.delete', [$row->id]) . '" title="Delete">Delete</a>';

                if ($row->approved == 0) {
                    $returnVal .= '<a class="btn btn-sm btn-success" href="' . route('article.approve', [$row->id]) . '" title="Approve">Approve</a>';
                }
                return $returnVal;

            }]);

        return view('article.index', ['grid' => $datagrid,
            'articles' => $articles]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public
    function create()
    {
        return view('article.create', [
            'action' => route('article.store'),
            'type' => 'create',
            'method' => 'post',
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

        $article = Article::create([
            'text' => request('text'),
            'title' => request('title'),
            'approved' => 0,
            'user_id' => auth()->id()
        ]);

        $article->save();

        return redirect()->route('article.index');
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

        $article->update($request->all());
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
        return redirect()->route('article.index');

    }

    public
    function approve(Article $article)
    {
        $article->approved = 1;
        $article->save();
        return redirect()->route('article.index');
    }
}
