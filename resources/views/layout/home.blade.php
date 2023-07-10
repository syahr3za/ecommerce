<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title', 'Home')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700%7COpen+Sans:400,400i,600,700' rel='stylesheet'>
    <!-- Css -->
    <link rel="stylesheet" href="/front/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/front/css/magnific-popup.css" />
    <link rel="stylesheet" href="/front/css/font-icons.css" />
    <link rel="stylesheet" href="/front/css/sliders.css" />
    <link rel="stylesheet" href="/front/css/style.css" />
    <!-- Favicons -->
    <link rel="shortcut icon" href="/front/img/favicon.ico">
    <link rel="apple-touch-icon" href="/front/img/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/front/img/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/front/img/apple-touch-icon-114x114.png">
</head>

<body class="relative">
    <!-- Preloader -->
    <div class="loader-mask">
        <div class="loader">
            <div></div>
            <div></div>
        </div>
    </div>
    <main class="main-wrapper">
        <header class="nav-type-1">
            <nav class="navbar navbar-static-top">
                <div class="navigation" id="sticky-nav">
                    <div class="container relative">
                        <div class="row flex-parent">
                            <div class="navbar-header flex-child">
                                <!-- Logo -->
                                <div class="logo-container">
                                    <div class="logo-wrap">
                                        <a href="/">
                                            @php
                                            $about = App\Models\About::first();
                                            @endphp
                                            <img class="logo-dark2" src="/uploads/{{$about->logo}}" alt="logo">
                                        </a>
                                    </div>
                                </div>

                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                            <div class="nav-wrap flex-child">
                                <div class="collapse navbar-collapse text-center" id="navbar-collapse">
                                    <ul class="nav navbar-nav">
                                        <li class="dropdown">
                                            <a href="/">Home</a>
                                        </li>
                                        <li class="dropdown">
                                            <a href="/about">About</a>
                                        </li>
                                        @php
                                        $categories = App\Models\Category::all();
                                        @endphp
                                        <li class="dropdown">
                                            <a href="#">Shop</a>
                                            <i class="fa fa-angle-down dropdown-trigger"></i>
                                            <ul class="dropdown-menu megamenu-wide">
                                                <li>
                                                    <div class="megamenu-wrap container">
                                                        <div class="row">
                                                            @foreach ($categories as $category)
                                                            <div class="col-md-3 megamenu-item">
                                                                <ul class="menu-list">
                                                                    <li>
                                                                        <span>{{$category->category_name}}</span>
                                                                    </li>
                                                                    @php
                                                                    $sub_categories = App\Models\Subcategory::where('category_id', $category->id)->get();
                                                                    @endphp
                                                                    @foreach ($sub_categories as $subcategory)
                                                                    <li>
                                                                        <a href="/products/{{$subcategory->id}}">{{$subcategory->subcategory_name}}</a>
                                                                    </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a href="/contact">Contact Us</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="flex-child flex-right nav-right hidden-sm hidden-xs">
                                <ul>
                                    <li class="nav-register">
                                        @if (Auth::guard('webmember')->check())
                                        <a href="#">{{Auth::guard('webmember')->user()->member_name}} </a>
                                        @else
                                        <a href="/login_member">Login </a>
                                        @endif
                                    </li>
                                    <li class="nav-cart">
                                        <div class="nav-cart-outer">
                                            <div class="nav-cart-inner">
                                                <a href="/cart" class="nav-cart-icon"></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="nav-register">
                                        @if (Auth::guard('webmember')->check())
                                        <a href="/logout_member">Logout</a>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <div class="content-wrapper oh">
            @yield('content')
            <footer class="footer footer-type-1">
                <div class="container">
                    <div class="footer-widgets">
                        <div class="row">
                            <div class="col-md-3 col-sm-12 col-xs-12">
                                <div class="widget footer-about-us">
                                    <img src="/front/img/images__1_-removebg-preview.png" alt="" class="logo">
                                    <p class="mb-30">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                    <div class="footer-socials">
                                        <div class="social-icons nobase">
                                            <a href="#"><i class="fa fa-twitter"></i></a>
                                            <a href="#"><i class="fa fa-facebook"></i></a>
                                            <a href="#"><i class="fa fa-google-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-md-offset-1 col-sm-6 col-xs-12">
                                <div class="widget footer-links">
                                    <h5 class="widget-title bottom-line left-align grey">About</h5>
                                    <ul class="list-no-dividers">
                                        <li><a href="#">About us</a></li>
                                        <li><a href="#">Features</a></li>
                                        <li><a href="#">News</a></li>
                                        <li><a href="#">Menu</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-6 col-xs-12">
                                <div class="widget footer-links">
                                    <h5 class="widget-title bottom-line left-align grey">Company</h5>
                                    <ul class="list-no-dividers">
                                        <li><a href="#">Why us?</a></li>
                                        <li><a href="#">Partners with us</a></li>
                                        <li><a href="#">FAQ</a></li>
                                        <li><a href="#">Blogs</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-6 col-xs-12">
                                <div class="widget footer-links">
                                    <h5 class="widget-title bottom-line left-align grey">Support</h5>
                                    <ul class="list-no-dividers">
                                        <li><a href="#">Account</a></li>
                                        <li><a href="#">Support center</a></li>
                                        <li><a href="#">Feedback</a></li>
                                        <li><a href="#">Terms &amp; Conditions</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-6 col-xs-12">
                                <div class="widget footer-links">
                                    <h5 class="widget-title bottom-line left-align grey">Service</h5>
                                    <ul class="list-no-dividers">
                                        <li><a href="#">Warranty</a></li>
                                        <li><a href="#">Accessibility</a></li>
                                        <li><a href="#">Contact us</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bottom-footer">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-6 copyright sm-text-center">
                                <span>
                                    &copy; Copyright 2023 All right reserved|Built by Boya
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <div id="back-to-top">
                <a href="#top"><i class="fa fa-angle-up"></i></a>
            </div>
        </div>
    </main>

    <!-- jQuery Scripts -->
    <script type="text/javascript" src="/front/js/jquery.min.js"></script>
    <script type="text/javascript" src="/front/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/front/js/plugins.js"></script>
    <script type="text/javascript" src="/front/js/scripts.js"></script>
    @stack('js')
</body>

</html>