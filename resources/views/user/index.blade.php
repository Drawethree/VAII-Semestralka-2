@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('User Manager') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @can('create', App\Models\User::class)
                            <div class="mb-3">
                                <a href="{{route('admin.user.create')}}" class="btn btn-success"><i class="fa fa-plus-circle">&nbsp;</i>{{__('Add new user')}}</a>
                            </div>
                        @endcan
                        {!! $grid->show() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
