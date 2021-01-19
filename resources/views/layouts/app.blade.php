<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.tiny.cloud/1/k6x8z4me2jtlcx50pnxn9nte46nq69eybd4604tchz6znras/tinymce/5/tinymce.min.js"
            referrerpolicy="origin"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/particles.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <div id="particles-js"></div>

    <script src="{{ asset('js/particles.js') }}"></script>

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

    <script>
        particlesJS("particles-js", {
            "particles": {
                "number": {"value": 160, "density": {"enable": true, "value_area": 800}},
                "color": {"value": "#ffffff"},
                "shape": {
                    "type": "circle",
                    "stroke": {"width": 0, "color": "#000000"},
                    "polygon": {"nb_sides": 5},
                    "image": {"src": "img/github.svg", "width": 100, "height": 100}
                },
                "opacity": {
                    "value": 1,
                    "random": true,
                    "anim": {"enable": true, "speed": 1, "opacity_min": 0, "sync": false}
                },
                "size": {
                    "value": 3,
                    "random": true,
                    "anim": {"enable": false, "speed": 4, "size_min": 0.3, "sync": false}
                },
                "line_linked": {"enable": false, "distance": 150, "color": "#ffffff", "opacity": 0.4, "width": 1},
                "move": {
                    "enable": true,
                    "speed": 1,
                    "direction": "none",
                    "random": true,
                    "straight": false,
                    "out_mode": "out",
                    "bounce": false,
                    "attract": {"enable": false, "rotateX": 600, "rotateY": 600}
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {"enable": true, "mode": "bubble"},
                    "onclick": {"enable": false, "mode": "repulse"},
                    "resize": true
                },
                "modes": {
                    "grab": {"distance": 400, "line_linked": {"opacity": 1}},
                    "bubble": {"distance": 250, "size": 0, "duration": 2, "opacity": 0, "speed": 3},
                    "repulse": {"distance": 400, "duration": 0.4},
                    "push": {"particles_nb": 4},
                    "remove": {"particles_nb": 2}
                }
            },
            "retina_detect": true
        });
        var count_particles, stats, update;
        stats = new Stats;
        stats.setMode(0);
        stats.domElement.style.position = 'absolute';
        stats.domElement.style.left = '0px';
        stats.domElement.style.top = '0px';
        document.body.appendChild(stats.domElement);
        count_particles = document.querySelector('.js-count-particles');
        update = function () {
            stats.begin();
            stats.end();
            if (window.pJSDom[0].pJS.particles && window.pJSDom[0].pJS.particles.array) {
                count_particles.innerText = window.pJSDom[0].pJS.particles.array.length;
            }
            requestAnimationFrame(update);
        };
        requestAnimationFrame(update);
        ;
    </script>

    <nav class="navbar navbar-expand-md navbar-dark bg-primary navbar-collapse">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}"><img
                    src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" width="25" height="25"
                    alt="logo">
                {{ substr(config('app.name', 'Laravel'),1) }}</a>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <div class="navbar-nav mr-auto">
                    @auth
                        @if(Auth::check() && Auth::user()->getIsAdminAttribute())
                            <div class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Admin
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                                    @can('viewAny', Auth::user())
                                        <a class="dropdown-item" href="{{ route('users') }}"><i class="fa fa-user-plus">&nbsp;</i> {{__('Manage Users')}}
                                        </a>
                                    @endcan
                                    @can('viewAny', \App\Models\Article::class)
                                        <a class="dropdown-item"
                                           href="{{ route('article.index') }}"><i
                                                class="fa fa-newspaper-o">&nbsp;</i> {{__('Manage Articles')}}</a>
                                    @endcan
                                </div>
                            </div>
                        @endif
                    @endauth

                    @foreach(\App\Models\Forum::all() as $forum)
                        <a class="nav-item nav-link"
                           href="{{route('forum.view', $forum->id)}}">{{__($forum->title)}}</a>
                    @endforeach
                </div>

                <!-- Right Side Of Navbar -->
                <div class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <div class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </div>
                        @endif

                        @if (Route::has('register'))
                            <div class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </div>
                        @endif
                    @else
                        <img src="/uploads/avatars/{{ Auth::user()->avatar }}"
                             style="width:32px; height:32px;border-radius:50%" alt="avatar">
                        <div class="nav-item dropdown"><a
                                id="navbarDropdown2" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->username }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown2">

                                @can('update', Auth::user())
                                    <a class="dropdown-item"
                                       href="{{ route('user.edit', [Auth::user()->id]) }}">{{ __('Edit Profile') }}
                                    </a>
                                @endcan

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i
                                        class="fa fa-btn fa-sign-out">&nbsp;</i> {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 mt-3">
                <div class="card text-white bg-secondary mb-3">
                    <div class="card-header"><i class="fa fa-globe">&nbsp;</i> Latest posts</div>
                    @foreach(\App\Models\Article::orderBy('updated_at', 'desc')->where('approved', 1)->take(5)->get() as $post)
                        <div class="card-body">
                            <p class="card-title"><a
                                    href=" {{ route('article.view', $post->id) }}">{{$post->title}}</a> in <a
                                    href="{{ route('forum.view', $post->forum->id) }}">{{$post->forum->title}}</a>
                            </p>
                            <p class="card-text">Created by: {{ $post->user->username }}</p>
                            <p class="card-text"><i class="fa fa-comments"
                                                    aria-hidden="true">&nbsp;</i>{{$post->comments->count()}}
                                comments</p>
                            <p class="card-text"><i class="fa fa-calendar-check-o"
                                                    aria-hidden="true">&nbsp;</i>{{$post->updated_at->diffForHumans()}}
                        </div>
                    @endforeach
                </div>
            </div>

            <main class="col-md-8">
                @yield('content')
            </main>

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
</body>
</html>

