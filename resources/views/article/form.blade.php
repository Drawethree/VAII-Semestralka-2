<form method="post" action="{{ $action }}">
    @csrf
    @method($method)
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
               placeholder="Title"
               value="{{old('title', @$model->title)}}">
        @error('title')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>

    <div class="form-group">
        <input type="hidden" class="form-control" id="forum_id" name="forum_id" value="{{@$forum->id}}">
    </div>

    <div class="form-group">
        <label for="text">Text</label>
        <textarea class="form-control" id="text" name="text"
        >{{ old('text', @$model->text) }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary form-control"> @if($type == 'create') Submit for approval @else
            Edit
            Article @endif</button>
</form>
<script>
    tinymce.init({
        selector: 'textarea',
        plugins: 'a11ychecker advcode casechange formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
        toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table',
        toolbar_mode: 'floating',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
    });
</script>
