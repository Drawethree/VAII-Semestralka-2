<form method="post" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @method($method)
    <div class="form-group">
        <label for="name">Full name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Full name"
               value=" {{ old('name', @$model->name) }}">
        @error('name')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email"
               value="{{ @$model->email }}">
        @error('email')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Username"
               value="{{ @$model->username }}">
        @error('username')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" value="">
        @error('password')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="password">Password again</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
               placeholder="Confirm password" value="">
        @error('password_confirmation')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="avatar">Profile picture</label>
        <input type="file" class="form-control-file" name="avatar"
               placeholder="Profile picture" id="avatar">
        @error('avatar')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary form-control">
    </div>

</form>
