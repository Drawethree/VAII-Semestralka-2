@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="card mt-3">
        <div class="card-body">
            <div class="row no-gutters">
                <div class="col-md-auto mt-3">
                    <img class="card-img-top" src="/uploads/avatars/{{ $article->user->avatar }}" alt="avatar"
                         style="width:64px; height:64px;border-radius:50%">
                </div>
                <div class="col-md-auto">
                    <div class="card-body">
                        <h4 class="card-title">{{ $article->title }}</h4>
                        <h6 class="card-subtitle mb-2 text-muted">Created
                            by: {{ $article->user->username }}</h6>
                        <div class="card-text"> {!! $article->text !!}</div>
                        <p class="card-text"><i class="fa fa-calendar-check-o"
                                                aria-hidden="true">&nbsp;</i>{{$article->updated_at->diffForHumans()}}
                        </p>
                        <p class="card-text"><i class="fa fa-comments"
                                                aria-hidden="true">&nbsp;</i>{{$article->comments->count()}}
                            comments</p>
                    </div>
                    @auth
                        @if(Auth::user()->can('update', $article))
                            <a href="{{route('article.edit', [$article->id])}}" class="btn btn-primary"><i
                                    class="fa fa-pencil-square-o" aria-hidden="true">&nbsp;</i>Edit
                            </a>
                        @endif
                        @if(Auth::user()->can('delete', $article))
                            <a href="{{route('article.delete', [$article->id])}}" class="btn btn-danger"><i
                                    class="fa fa-trash" aria-hidden="true">&nbsp;</i>Delete
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
    @auth
        @if(Auth::user()->can('create', \App\Models\Comment::class))
            <form class="mt-3" method="PUT" action="{{ route('comment.create', [$article->forum, $article]) }}">
                <div class="form-group">
                    <label for="text" class="text-white"><i class="fa fa-comments" aria-hidden="true">&nbsp;</i>Add
                        Comment</label>
                    <input type="hidden" name="article_id" id="article_id" value=" {{ $article->id }}">
                    <textarea class="form-control @error('text') is-invalid @enderror"
                              id="text"
                              name="text"
                              placeholder="Text"></textarea>
                    @error('text')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary form-control"><i class="fa fa-plus-circle">&nbsp;</i> Add
                    Comment
                </button>
            </form>
        @endif
    @endauth
    @foreach($article->comments()->orderBy('created_at', 'desc')->get() as $comment)
        <div class="card mt-3">
            <div class="card-body">
                <img class="card-img-top" src="/uploads/avatars/{{ $comment->user->avatar }}" alt="avatar"
                     style="width:32px; height:32px;border-radius:50%">
                <h5 class="card-title">{{ $comment->user->username }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ $comment->text }}</h6>
                <p class="card-text"><i class="fa fa-calendar-check-o"
                                        aria-hidden="true">&nbsp;</i>{{$comment->updated_at->diffForHumans()}}
                </p>
                @auth
                    @if(Auth::user()->can('delete', $comment))
                        <div class="mt-3">
                            <a href="{{ route('comment.delete', [$comment->article->forum, $comment->article, $comment]) }}"
                               class="btn btn-outline-danger"><i class="fa fa-trash"
                                                                 aria-hidden="true">&nbsp;</i>{{__('Delete')}}
                            </a>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    @endforeach
    @guest
        <h6 class="text-white mt-3">To add a comment please <a
                href="{{ route('login') }}">login</a></h6>
    @endguest
@endsection
