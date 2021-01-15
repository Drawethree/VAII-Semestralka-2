@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if(Auth::user()->can('create', Article::class))
                    <div class="mb-3">
                        <a href="{{route('article.create')}}" class="btn btn-success">{{__('Create new article')}}</a>
                    </div>
                @endif

                @foreach($articles as $article)
                    @if (Auth::user()->can('view', $article))
                        <div class="card mt-5">
                            <div class="card-body">
                                <h5 class="card-title">{{ $article->title }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ App\Models\User::find('id', [$article->user_id])->username}}</h6>
                                <p class="card-text">{{$article->text}}</p>
                                <p class="card-text">{{$article->updated_at->diffForHumans()}}</p>
                                @if(Auth::user()->can('update', $article))
                                    <a href="{{route('article.edit', [$article->id])}}" class="btn btn-primary">Edit
                                        Article</a>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
