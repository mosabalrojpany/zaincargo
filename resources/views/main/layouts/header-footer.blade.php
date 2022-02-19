<!doctype html>
<html lang="ar" dir="rtl">

<head>
    
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="keywords" content="{{ app_settings()->keywords }}">
    <meta name="description" content="{{ app_settings()->desc }}">

    <meta property="og:url"     content="{{ Request::url() }}" />
    <meta property="og:site_name" content="{{ config('app.name') }}" />
    <meta name='twitter:domain' content='{{ url('/') }}' />
    
    @hasSection ('extra-meta')
    
        @yield('extra-meta')
    
    @else
    
        <meta property="og:title" content="{{ config('app.name') }}" />
        <meta property="og:description" content="{{ app_settings()->desc }}">
        <meta property="og:image" content="{{ url('images/logo-with-title-bg.jpg') }}" />
        <meta property="og:image:secure_url" content="{{ secure_url('images/logo-with-title-bg.jpg') }}" />
        <meta property="og:type" content="website" />

        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="{{ config('app.name') }}" />
        <meta name="twitter:description" content="{{ app_settings()->desc }}">
        <meta name="twitter:image" content="{{ url('images/logo.png') }}" />
        
    @endif
    

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->

    <title>@yield('title',config('app.name'))</title>

    <!-- favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('images/logo.png') }}">
    
    <!-- bootstrap css -->
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}">
    <!-- fontawesome css -->
    <link rel="stylesheet" href="{{ url('assets/css/flaticon.css') }}">
    <!-- fontawesome css -->
    <link rel="stylesheet" href="{{ url('assets/css/fontawesome.min.css') }}">
    <!-- owl carousel css -->
    <link rel="stylesheet" href="{{ url('assets/css/owl.carousel.min.css') }}">
    <!-- owl carousel theme css -->
    <link rel="stylesheet" href="{{ url('assets/css/owl.theme.default.min.css') }}">
    <!-- slicknav css -->
    <link rel="stylesheet" href="{{ url('assets/css/slicknav.css') }}">
    <!-- animate css -->
    <link rel="stylesheet" href="{{ url('assets/css/animate.min.css') }}">
    <!-- main css -->
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">
    <!-- responsive css -->
    <link rel="stylesheet" href="{{ url('assets/css/responsive.css') }}">

    <style>

        @font-face {
            font-family: 'Tajawal';
            font-style: normal;
            font-weight: 400;
            src: url(../fonts/Tajawal/Tajawal-Medium.ttf);
        }

        body {
            font-family: Tajawal;
            direction: rtl;
            text-align: right;
        }
        .editor-content img {
            max-width: 100% !important;
            height: auto !important;
        }
        /* Start overwrite bootstrap */
        .alert {
            padding-left: 3rem;
            padding-right: 1.25rem;
        }
        .alert>ul {
            padding-right: 20px;
        }
        .alert>button {
            top: 0 !important;
            left: 0 !important;
            right: unset !important;
            background-color: transparent !important;
        }
        .modal-header .close {
            position: unset !important;
        }
        .custom-control-label::before,
        .custom-control-label::after {
            right: -1.5rem;
        }
        .custom-file {
            height: 50px;
            line-height: 50px;
            border: none;
            outline: 0;
            color: #4e5861;
        }
        .custom-file-input {
            height: inherit;
        }
        .custom-file-label {
            text-align: right;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            height: 50px;
            line-height: 50px;
            border: none;
            border-radius: 0;
            outline: 0;
            padding : 0 20px 0 70px;
            color: #4e5861;
        }
        .custom-file-label::after {
            left: 0;
            right: unset;
            border-left: none;
            border-right: inherit;
            border-radius: inherit;
            content: "تصفح";    
            padding-top: inherit;
            padding-bottom: inherit;
            line-height: inherit;
            height: inherit;
        }
        /* End overwrite bootstrap */
    </style>
</head>


<body>





    <!--   header area start   -->
    <div class="header-area home-3">

        {{-- Start Upper-bar --}}
        <div class="info-bar">
            <div class="container">
                <div class="row justify-content-between">

                    <div class="col-auto d-none d-sm-flex">

                        <div class="contact-infos d-none d-lg-inline-flex">
                            <div class="email">
                                <div class="icon-wrapper"><i class="flaticon-email"></i></div>
                                <div><bdi>{{ app_settings()->email }}</bdi></div>
                            </div>
                            <div class="phone">
                                <div class="icon-wrapper"><i class="flaticon-call"></i></div>
                                <div><bdi>{{ app_settings()->phone }}</bdi></div>
                            </div>
                        </div>
                            
                        <ul class="social-links">

                            @if(app_settings()->facebook)
                                <li><a href="{{ app_settings()->facebook }}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                            @endif
                            
                            @if(app_settings()->instagram)
                                <li><a href="{{ app_settings()->instagram }}" target="_blank"><i class="fab fa-instagram"></i></a></li>
                            @endif
                            
                            @if(app_settings()->twitter)
                                <li><a href="{{ app_settings()->twitter }}" target="_blank"><i class="fab fa-twitter"></i></a></li>
                            @endif
                            
                            @if(app_settings()->youtube)
                                <li><a href="{{ app_settings()->youtube }}" target="_blank"><i class="fab fa-youtube"></i></a></li>
                            @endif
                        
                        </ul>

                    </div>

                    <div class="col-sm-auto mr-auto">
                        
                        <ul class="users-links d-flex justify-content-between">
                            
                            @if(authClient()->check())
                            
                                <li>
                                    <a href="{{ url('client/index') }}"><i class="fa fa-user ml-1"></i>{{ authClient()->user()->name }}</a>
                                </li>
                            
                            @else
                            
                                <li>
                                    <a href="#" data-toggle="modal" data-target="#loginModal"><i class="fa fa-user ml-1"></i>login</a>
                                </li>
                                <li>
                                    <a href="{{ url('client/register') }}"><i class="fa fa-user-plus ml-1"></i>register</a>
                                </li>
                            
                            @endif
                        
                        </ul>

                    </div>

                </div>
            </div>
        </div>
        {{-- End Upper-bar --}}


        {{-- Start navbar --}}
        <div class="support-nav-area">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-6">
                        <div class="logo-wrapper">
                            <div class="logo-wrapper-inner">
                                <a href="{{ url('/') }}" title="{{ config('app.name') }}">
                                    <img src="{{ url('assets/img/main-logo.png') }}" alt="{{ config('app.name') }}">
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-9 col-6 position-static">
                        <div class="navbar-area">
                            <div class="row">
                                <div class="col-12 position-static">
                                    <nav class="main-menu" id="mainMenuHome3">
                                        <ul>
                                            <li class="{{ Request::is('/')? 'active' : '' }}">
                                                <a href="{{ url('/') }}">home</a>
                                            </li>
                                            <li class="{{ is_page_active('about') }}">
                                                <a href="{{ url('about') }}">about us</a>
                                            </li>
                                            <li class="{{ is_page_active('news') }}">
                                                <a href="{{ url('news') }}">news</a>
                                            </li>
                                            <li class="{{ is_page_active('faq') }}">
                                                <a href="{{ url('faq') }}">FAQ</a>
                                            </li>
                                            <li class="{{ is_page_active('contact') }}">
                                                <a href="{{ url('contact') }}">contact us</a>
                                            </li>
                                        </ul>
                                    </nav>
                                    <div id="mobileMenuHome3"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        {{-- End navbar --}}

    </div>
    <!--   header area end   -->




    @yield('content')




    <!--   footer section start    -->
    <footer>
        <div class="container">

            <div class="top-footer">
                <div class="row">

                    <div class="col-lg-4 offset-xl-1 mb-3">

                        <div class="logo-wrapper">
                            <img src="{{ url('assets/img/main-logo.png') }}" alt="{{ config('app.name') }}">
                        </div>
                        <p>{{ app_settings()->desc }}</p>
                        
                        <ul class="social-links">

                            @if(app_settings()->facebook)
                                <li><a href="{{ app_settings()->facebook }}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                            @endif
                            
                            @if(app_settings()->instagram)
                                <li><a href="{{ app_settings()->instagram }}" target="_blank"><i class="fab fa-instagram"></i></a></li>
                            @endif
                            
                            @if(app_settings()->twitter)
                                <li><a href="{{ app_settings()->twitter }}" target="_blank"><i class="fab fa-twitter"></i></a></li>
                            @endif
                            
                            @if(app_settings()->youtube)
                                <li><a href="{{ app_settings()->youtube }}" target="_blank"><i class="fab fa-youtube"></i></a></li>
                            @endif
                        
                        </ul>

                    </div>

                    <div class="col-sm-6 col-lg-2 mb-3">
                        <h4>روابط مفيدة</h4>
                        <ul class="userful-links">
                            <li><a href="{{ url('/') }}">home</a></li>
                            <li><a href="{{ url('about') }}">about us</a></li>
                            <li><a href="{{ url('news') }}">news</a></li>
                            <li><a href="{{ url('faq') }}">FAQ</a></li>
                            <li><a href="{{ url('contact') }}">contact us</a></li>
                        </ul>
                    </div>

                    <div class="col-sm-6 col-lg-2 mb-3">
                        <h4>other url</h4>
                        <ul class="userful-links">
                            <li><a href="{{ url('terms') }}">اتفاقية الاستخدام</a></li>
                            <!--<li><a href="{{ url('public-files/shipping-guide.pdf') }}" target="_blank">دليل الشحن</a></li>-->
                            <!--<li><a href="#">دليل الاستعمال</a></li>-->
                        </ul>
                    </div>

                    <div class="col-xl-3 col-lg-4">
                        <h4>اتصل بنا</h4>
                        <div class="footer-contact">
                            <div class="contact-info">
                                <div class="icon-wrapper"><i class="flaticon-placeholder"></i></div>
                                <p>{{ app_settings()->address }}</p>
                            </div>
                            <div class="contact-info">
                                <div class="icon-wrapper"><i class="flaticon-call"></i></div>
                                <p><bdi>{{ app_settings()->phone }}</bdi></p>
                            </div>
                            <div class="contact-info">
                                <div class="icon-wrapper"><i class="flaticon-email"></i></div>
                                <p>{{ app_settings()->email }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="bottom-footer">
                <p class="text-center">جميع الحقوق محفوظة ل{{ config('app.name') }} &copy; <bdi>{{ date('Y') }}</bdi></p>
            </div>

        </div>
    </footer>
    <!--   footer section end    -->


    <!-- preloader section start -->
    <div class="loader-container">
        <span class="loader">
            <span class="loader-inner"></span>
        </span>
    </div>
    <!-- preloader section end -->


    <!-- back to top area start -->
    <div class="back-to-top">
        <i class="fas fa-chevron-up"></i>
    </div>
    <!-- back to top area end -->


    {{-- Modal login start --}}
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" class="formSendAjaxRequest" btnsuccess="hide" refresh-seconds="0" action="{{ url('client/login') }}" msgsuccess="جاري الدخول..."> 
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginModalLabel">lgoin</h5>
                        <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    
                        {{ csrf_field() }}
                        
                        <div class="formResult"></div> 
                        <div class="form-group row mt-2" style="direction: ltr;">
                            <label class="col-md-4 col-form-label pr-4" style="text-align: left;max-width: 80px;">email</label>
                            <div class="col-md-8 pr-sm-0">
                                <input type="email" name="email" maxlength="64" class="form-control text-center" required placeholder="example@domain.com">
                            </div>
                        </div>
                        <div class="form-group row" style="direction: ltr;">
                            <label class="col-md-4 col-form-label pr-4" style="text-align: left;max-width: 80px;">password</label>
                            <div class="col-md-8 pr-sm-0">
                                <input type="password" name="password" maxlength="32" class="form-control text-center" required placeholder="**********">
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-md-8">
                                <div class="form-group pr-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="remember" class="custom-control-input" id="customControlRememberPassword">
                                        <label class="custom-control-label" for="customControlRememberPassword" style="direction: ltr;margin: 0;padding: 0;">remembar password</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary px-4">login</button>
                        <a href="{{ url('client/register') }}" class="btn btn-secondary mr-2 px-4">register</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Modal login end --}}


    <!-- Optional JavaScript -->
    <script src="{{ url('assets/js/jquery-3.3.1.min.js') }}"></script>    
    <script src="{{ url('assets/js/popper.min.js') }}"></script>    
    <script src="{{ url('assets/js/bootstrap.min.js') }}"></script>    
    <script src="{{ url('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ url('assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ url('assets/js/jquery.slicknav.min.js') }}"></script>
    <script src="{{ url('assets/js/wow.min.js') }}"></script>
    <script src="{{ url('assets/js/main.js') }}"></script>
    <script>
        $('#loginModal').on('shown.bs.modal',function(){
            $(this).find('input[name="email"]').focus();
        });
    </script>
    @yield('extra-js') 
</body>

</html>