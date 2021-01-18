@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                @auth
                    @if(Auth::user()->can('create', \App\Models\Article::class))
                        <div class="mt-3">
                            <a href="{{route('article.create')}}"
                               class="btn btn-success">{{__('Create new article')}}</a>
                        </div>
                    @endif
                @endauth

                @foreach($articles as $article)
                    <div class="card mt-3">
                        <div class="card-body">
                            <img class="card-img-top" src="/uploads/avatars/{{ $article->user->avatar }}"
                                 style="width:32px; height:32px;border-radius:50%">
                            <a href="{{ route('article.view', [$article->id]) }}"><h5 class="card-title">{{ $article->title }}</h5></a>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $article->user->username }}</h6>
                            <p class="card-text">{{$article->updated_at->diffForHumans()}}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-center pt-5">
                {!! $articles->links() !!}
            </div>
        </div>
    </div>
@endsection

