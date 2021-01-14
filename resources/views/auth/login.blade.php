@extends('index')

@section('content')
    <div class="col-md-4">
        <div id="login-form" class="text-center">

            <form method="POST" class="form-signin" action="{{ route('login') }}">
                @csrf
                <img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt=""
                     width="72"
                     height="72">
                <h1 class="h3 mb-3 font-weight-normal">Please Sign In</h1>
                <label for="login" class="sr-only">{{ __('Email or Username') }}</label>
                <input type="text" id="login"
                       class="form-control {{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}"
                       placeholder="Email or username" value="{{ old('username') ?: old('email') }}" required autofocus>

                @if ($errors->has('username') || $errors->has('email'))
                    <span class="invalid-feedback">
                                            <strong>{{ $errors->first('username') ?: $errors->first('email') }}</strong>
                                        </span>
                @endif

                <label for="password" class="sr-only">{{ __('Password') }}</label>
                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                       placeholder="Password" required>

                @error('password')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror


                <div class="checkbox mb-3">
                    <input class="form-check-input" type="checkbox" name="remember"
                           id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>

                <button type="submit" class="btn btn-lg btn-primary btn-block">Sign in</button>
                <button type="submit" class="btn btn-lg btn-primary btn-block">or Register</button>
                <p class="mt-5 mb-3 text-muted">&copy; 2021 Ján Kluka</p>
            </form>
        </div>
    </div>
@endsection
