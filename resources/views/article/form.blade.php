<form method="post" action="{{ $action }}">
    @csrf
    @method($method)

    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Title"
               value="{{old('title', @$model->title)}}">
        @error('title')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="text">Title</label>
        <input type="text" class="form-control @error('text') is-invalid @enderror" id="text" placeholder="Text"
               value="{{old('text', @$model->text)}}">
        @error('title')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary form-control"> @if($type == 'create') Submit for approval @else Edit
        Article @endif</button>
</form>
