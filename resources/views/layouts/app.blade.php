<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('custom-meta-tags')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'QuizTime') }}</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" sizes="114x114"  href="{{ asset('favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet"  href="{{ asset('css/responsive-tabs.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script src="https://unpkg.com/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="{{ asset('js/jquery.responsiveTabs.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</head>
<style type="text/css">
    a{
        text-decoration: none !important;
    }

    .dropdown-item:hover {
        background-color: #fff!important;
    }
</style>

<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('input[type="radio"]').click(function(){
            var inputValue = $(this).attr("value");
            var targetBox = $("." + inputValue);
            $(".box").not(targetBox).hide();
            $(targetBox).show();
        });
        var windowHeight = $(window).height();
        var headerHeight = $("header").height();
        var footerHeight = $("footer").outerHeight();
        var pageMinHeight = windowHeight - footerHeight;
        $(".page-min-height").css({"min-height": pageMinHeight,"padding-top": headerHeight + 40});
        $(window).on("load resize",function(){
            var windowHeight = $(window).height();
            var headerHeight = $("header").height();
            var footerHeight = $("footer").outerHeight();
            var pageMinHeight = windowHeight - footerHeight;
            $(".page-min-height").css({"min-height": pageMinHeight,"padding-top": headerHeight + 40});
        });
        $('.startButton').hover(
           function(){ $(this).addClass('btn-outline-primary') },
           function(){ $(this).removeClass('btn-primary') }
           )

        $(window).on('load resize', function(){
            var headerHeight = $('header').height();
            $('.banner_content .col-lg-7, .banner_content .col-lg-5').css({'padding-top': headerHeight});
            $(window).scroll(function(){
                if($(document).scrollTop() > 100){
                    $('.header_content').addClass('small_header');
                }
                else{
                    $('.header_content').removeClass('small_header');
                }
            });
        });
        $('.nav_toggle_btn').click(function(){
            $('.header_menu').addClass('open');
            $('body').addClass('menu_open');
        });
        $('.close_menu_in_mobile > a').click(function(){
            $('.header_menu').removeClass('open');
            $('body').removeClass('menu_open');
        });
        $(".back_to_top").click(function(event) {
            event.preventDefault();
            $("html, body").animate({ scrollTop: 0 }, "slow");
        });
        $(window).scroll(function(){
            if ($(window).scrollTop() > 100) {
                $('.back_to_top').fadeIn();
            } else {
                $('.back_to_top').fadeOut();
            }
        });
    });
</script>
@yield('custom-scripts')
<body>
    <div id="app">
        <header>
            <div class="header_content">
                <div class="container">
                    <button class="nav_toggle_btn float-left">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </button>
                    <div class="logo float-left">
                        <a href="{{ url('/home') }}"><span>Quizo</span>phile</a>
                    </div>
                    <div class="header_menu float-right">
                        <div class="menu_content_with_overlay">
                            <div class="close_menu_in_mobile">
                                <a class="float-right" href="javascript:void(0);">Close <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                            </div>
                            <nav>
                                <ul class="main_menu">
                                    @if (Auth::guest())
                                    <li class="{{ set_active(['login*']) }}">
                                        <a href="{{ url('/login') }}">Login</a>
                                    </li>
                                    <li class="{{ set_active(['register*']) }}">
                                        <a href="{{ url('/register') }}">Signup</a>
                                    </li>
                                    @else
                                    <li class="{{ set_active(['home*']) }}">
                                        <a href="{{ url('/home') }}">Home</a>
                                    </li>
                                    <li class="{{ set_active(['createQuiz*']) }}">
                                        <a href="{{ url('/createQuiz') }}">Create Quiz</a>
                                    </li>
                                    <li class="{{ set_active(['userResults*']) }}">
                                        <a href="{{ url('/userResults') }}">My Results</a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link " id="navbarDropdown1" data-target="#" href="http://example.com" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }} 
                                            <i class="fa fa-caret-down"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown1" style="min-width: auto!important">
                                            <li>
                                                <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();" style="color: black;border: none">Log out</a>
                                            </li>
                                        </ul>
                                    </li>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form> 
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        @yield('content')
        <footer id="footer">Copyright &copy; <strong>{{Date('Y')}}</strong> Quizophile. All Rights Reserved.</footer>
        <a class="back_to_top" href="javascript:void(0);">
            <i class="fa fa-chevron-up" aria-hidden="true"></i>
        </a>
    </div>
</body>
</html>
