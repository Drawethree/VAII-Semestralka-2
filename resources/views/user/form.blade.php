<form method="post" action=" {{$action}}">
    @csrf
    @method($method)
    <div class="form-group">
        <label for="name">Full name</label>
        <input type="text" class="form-control" id="name" placeholder="Full Name"
               value="{{old('name', @$model->name)}}">
    </div>
    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" id="email" aria-describedby="emailHelp"
               placeholder="Enter email" value="{{old('email',@$model->email)}}">
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input type="username" class="form-control" id="username" placeholder="Username" value="{{old('username', @$model->username)}}">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" placeholder="Password">
    </div>
    <div class="form-group">
        <label for="password_confirm">Password again</label>
        <input type="password" class="form-control" id="password_confirm" placeholder="Password">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
