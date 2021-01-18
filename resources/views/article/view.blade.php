@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-5">
                    <div class="card-body">
                        <h5 class="card-title">{{ $article->title }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $article->user->username }}</h6>
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
            </div>
        </div>
    </div>
@endsection
