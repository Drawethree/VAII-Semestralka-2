@extends('layouts.app')

@section('content')
    @foreach($forums as $forum)
        <div class="card mt-3 bg-light">
            <div class="row no-gutters">
                <div class="col-md-auto mt-3">
                    <img class="card-img-top" src="{{ $forum->getAvatarPath() }}" alt="logo"
                         style="width:64px; height:64px;border-radius:50%">
                </div>
                <div class="col-md-auto">
                    <div class="card-body">
                        <a href="{{ route('forum.view', [$forum->id]) }}"><h4
                                class="card-title">{{ $forum->title }}</h4></a>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $forum->description }}</h6>
                        <p class="card-text"><i class="fa fa-newspaper-o"
                                                aria-hidden="true">&nbsp;</i>{{$forum->articles->where('approved', 1)->count()}}
                            posts</p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection


