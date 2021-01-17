<form method="post" action=" {{$action}}">
    @csrf
    @method($method)
    <div class="form-group">
        <label for="name">Full name</label>
        <input type="text" class="form-control" id="name" placeholder="Full Name"
               value="{{old('name', @$model->name)}}" required>
    </div>

    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
               placeholder="Enter email" value="{{old('email',@$model->email)}}" required>
        @error('email')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="username">Username</label>
        <input type="username" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="Username"
               value="{{old('username', @$model->username)}}" required>
        @error('username')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password">
        @error('password')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="password_confirm">Password again</label>
        <input type="password" class="form-control @error('password_confirm') is-invalid @enderror" id="password_confirm" placeholder="Password">
        @error('password_confirm')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="image">Profile Picture</label>
        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" placeholder="Profile Picture">
        @error('image')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
