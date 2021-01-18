@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-5">
                    <div class="card-body">
                        <h4 class="card-title">{{ $article->title }}</h4>
                        <h6 class="card-subtitle mb-2 text-muted">Created by: {{ $article->user->username }}</h6>
                        <div class="card-text">
                            {!! $article->text !!}
                        </div>
                        <p class="card-text">{{$article->updated_at->diffForHumans()}}</p>
                        @auth
                            @if(Auth::user()->can('update', $article))
                                <a href="{{route('article.edit', [$article->id])}}" class="btn btn-primary">Edit
                                </a>
                            @endif
                            @if(Auth::user()->can('delete', $article))
                                <a href="{{route('article.delete', [$article->id])}}" class="btn btn-danger">Delete
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
                @if(Auth::user() != null && Auth::user()->can('create', \App\Models\Comment::class))
                <form class="mt-3" method="put" action="{{ route('comment.create') }}">
                    <div class="form-group">
                        <label for="text" class="text-white">Add Comment</label>
                        <input type="hidden" name="article_id" id="article_id" value=" {{ $article->id }}">
                        <input type="text" class="form-control @error('text') is-invalid @enderror" id="text"
                               name="text"
                               placeholder="Text">
                        @error('text')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary form-control">Add Comment</button>
                </form>
                @else
                    <h6 class="text-white text-muted mt-3">To add a comment please <a href="{{ route('login') }}">login</a></h6>
                @endif
                @foreach($article->comments as $comment)
                    <div class="card mt-3">
                        <div class="card-body">
                            <img class="card-img-top" src="/uploads/avatars/{{ $article->user->avatar }}"
                                 style="width:32px; height:32px;border-radius:50%">
                            <h5 class="card-title">{{ $comment->user->username }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $comment->text }}</h6>
                            <p class="card-text">{{$comment->updated_at->diffForHumans()}}</p>
                            @if(Auth::user()->can('delete', $comment))
                                <div class="mt-3">
                                    <a href="{{ route('comment.destroy', [$comment->id]) }}"
                                       class="btn btn-outline-danger">{{__('Delete')}}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
