@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                @foreach($articles as $article)
                    <div class="card mt-3">
                        <div class="row no-gutters">
                            <div class="col-md-auto mt-3">
                                <img class="card-img-top" src="/uploads/avatars/{{ $article->user->avatar }}"
                                     style="width:64px; height:64px;border-radius:50%" alt="avatar">
                            </div>
                            <div class="col-md-auto">
                                <div class="card-body">
                                    <a href="{{ route('article.view', [$article->forum,$article]) }}"><h4
                                            class="card-title">{{ $article->title }}</h4></a>
                                    <h6 class="card-subtitle mb-2 text-muted">Created
                                        by: {{ $article->user->username }}</h6>
                                    <p class="card-text"><i class="fa fa-calendar-check-o"
                                                            aria-hidden="true">&nbsp;</i>{{$article->updated_at->diffForHumans()}}
                                    </p>
                                    <p class="card-text"><i class="fa fa-comments"
                                                            aria-hidden="true">&nbsp;</i>{{$article->comments->count()}}
                                        comments</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @auth
                    @if(Auth::user()->can('create', \App\Models\Article::class))
                        <div class="mt-3">
                            <a href="{{ route('forum.newpost', [$forum]) }}"
                               class="btn btn-success"><i
                                    class="fa fa-plus-circle">&nbsp;</i>{{__('Create new article')}}
                            </a>
                        </div>
                    @endif
                @endauth
                @guest
                    <h6 class="text-white mt-3">To create an article please <a
                            href="{{ route('login') }}">login</a> or <a
                            href="{{ route('register') }}">register</a></h6>
                @endguest
                <div class="d-flex justify-content-center pt-5">
                    {!! $articles->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
