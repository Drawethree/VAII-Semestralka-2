@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Article Manager') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @auth
                            @can(Auth::user()->can('approve', \App\Models\Article::class) && $not_approved > 0)
                                <div class="mt-3">
                                    <a href="{{route('article.approveAll')}}" class="btn btn-success"><i
                                            class="fa fa-check">&nbsp;</i>{{__('Approve all')}}</a>
                                </div>
                            @endcan
                        @endauth
                        {!! $grid->show() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
