@extends('layouts.app')

@section('content')
    <script>
        function refreshBlogStatistics() {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                type: 'GET',
                url: "{{ route('blog.stats') }}",
                data: {_token: _token},
                success: function (data) {
                    animateValue("users_amount", 0, data.userCount, 1000);
                    animateValue("forums_amount", 0, data.forumsCount, 1000)
                    animateValue("articles_amount", 0, data.articlesCount, 1000);
                    animateValue("comments_amount", 0, data.commentsCount, 1000);
                }
            });
        }
    </script>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 mt-3">
                <div class="card text-white bg-secondary mb-3">
                    <div class="card-header"><i class="fa fa-globe">&nbsp;</i> Latest posts</div>
                    @foreach($last_posts as $post)
                        <div class="card-body">
                            <p class="card-title"><a
                                    href=" {{ route('article.view', $post->id) }}">{{$post->title}}</a> in <a
                                    href="{{ route('forum.view', $post->forum->id) }}">{{$post->forum->title}}</a>
                            </p>
                            <p class="card-text">Created by: {{ $post->user->username }}</p>
                            <p class="card-text"><i class="fa fa-calendar-check-o"
                                                    aria-hidden="true">&nbsp;</i>{{$post->updated_at->diffForHumans()}}
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-8">
                @foreach($forums as $forum)
                    <div class="card mt-3 bg-light">
                        <div class="row no-gutters">
                            <div class="col-md-auto mt-3">
                                <img class="card-img-top" src="{{ $forum->getAvatarPath() }}"
                                     style="width:64px; height:64px;border-radius:50%">
                            </div>
                            <div class="col-md-auto">
                                <div class="card-body">
                                    <a href="{{ route('forum.view', [$forum->id]) }}"><h4
                                            class="card-title">{{ $forum->title }}</h4></a>
                                    <h6 class="card-subtitle mb-2 text-muted">{{ $forum->description }}</h6>
                                    <p class="card-text"><i class="fa fa-newspaper-o"
                                                            aria-hidden="true">&nbsp;</i>{{$forum->articles->count()}}
                                        posts</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-md-2 mt-3">
                <div class="card border-primary mb-3">
                    <div class="card-header"><i class="fa fa-signal">&nbsp;</i> Blog Statistics</div>
                    <div class="card-body">

                        <h5 class="card-title"><i class="fa fa-user"
                                                  style="color:lightgray">&nbsp;</i> Users</h5>
                        <h4 class="card-text ml-4" id="users_amount"></h4>


                        <h5 class="card-title"><i class="fa fa-newspaper-o" style="color:lightgray">&nbsp;</i> Forums
                        </h5>
                        <h4 class="card-text ml-4" id="forums_amount"></h4>

                        <h5 class="card-title"><i class="fa fa-newspaper-o" style="color:lightgray">&nbsp;</i> Articles
                        </h5>
                        <h4 class="card-text ml-4" id="articles_amount"></h4>

                        <h5 class="card-title"><i class="fa fa-comments" style="color:lightgray">&nbsp;</i> Comments
                        </h5>
                        <h4 class="card-text ml-4" id="comments_amount"></h4>

                        <h5 class="card-title"><i class="fa fa-user-plus" style="color:lightgray">&nbsp;</i> New User
                        </h5>
                        <h6 class="card-text ml-4">{{ DB::table('users')->latest('created_at')->first()->username }}</h6>

                        <button id="refresh_button" class="btn btn-primary mt-3" onclick='refreshBlogStatistics()'><i
                                class="fa fa-sync-alt">&nbsp;</i>Refresh
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function animateValue(id, start, end, duration) {
            // assumes integer values for start and end

            var obj = document.getElementById(id);
            var range = end - start;
            // no timer shorter than 50ms (not really visible any way)
            var minTimer = 50;
            // calc step time to show all interediate values
            var stepTime = Math.abs(Math.floor(duration / range));

            // never go below minTimer
            stepTime = Math.max(stepTime, minTimer);

            // get current time and calculate desired end time
            var startTime = new Date().getTime();
            var endTime = startTime + duration;
            var timer;

            function run() {
                $('#refresh_button').attr('disabled', true);
                var now = new Date().getTime();
                var remaining = Math.max((endTime - now) / duration, 0);
                var value = Math.round(end - (remaining * range));
                obj.innerHTML = value;
                if (value == end) {

                    $('#refresh_button').attr('disabled', false);
                    clearInterval(timer);
                }
            }

            timer = setInterval(run, stepTime);
            run();
        }

        refreshBlogStatistics();
    </script>
@endsection


