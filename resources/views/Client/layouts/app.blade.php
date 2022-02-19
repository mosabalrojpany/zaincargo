<!doctype html>
<html lang="ar">

    <head>
        <title>@yield('title',config('app.name'))</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="icon" type="image/png"   href="{{ url('images/logo.png') }}">
        <!-- Bootstrap And Fontawsome CSS -->
        <link rel="stylesheet" href="{{ url('/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ url('/css/all.min.css') }}" >
        <link rel="stylesheet" href="{{ url('/css/style.css') }}" />
    </head>

<body>


    <div class="client-wrapper min-vh-100">
        <!--    StartSidebar     -->
        <nav id="client-sidebar" class="text-right text-white bg-primary vh-100">

            <h5 class="mt-3 pr-2 pl-3">
                <img class="mw-100" src="{{  url('images/logo-with-title.png') }}" />
            </h5>

            <hr/>

            <ul class="list-unstyled px-0">
                <li>
                    <a href="{{ url('/client/index') }}">
                        <span class="icon"><i class="fa fa-home"></i></span>
                        الرئيسية
                    </a>
                </li>
                <li>
                    <a href="{{ url('/client/shipping-invoices') }}">
                        <span class="icon"><i class="fa fa-cubes"></i></span>
                        الشحنات
                    </a>
                </li>
                <li>
                    <a href="{{ url('/client/wallet') }}">
                        <span class="icon"><i class="fa fa-wallet"></i></span>
                        المحفظة
                    </a>
                </li>
                @if(authClient()->user()->merchant_state == 1)
                <li>
                    <a href="{{ url('/client/merchant_prchase_order') }}">
                        <span class="icon"><i class="fa fa-shopping-cart"></i></span>
                        طلبات الشراء للتجار
                    </a>
                </li>
                @endif

                                    <li>
                        <a href="#subMenuwallet" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <span class="icon"><i class="fas fa-concierge-bell"></i></span>
                            طلب خدمة
                        </a>
                        <ul class="collapse list-unstyled" id="subMenuwallet" style="padding: 0;">
                            <li>
                                <a href="{{ url('/client/purchase-orders') }}">
                                    <span class="icon"><i class="fa fa-shopping-cart"></i></span>
                                    طلبات الشراء
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/client/money-transfers') }}">
                                    <span class="icon"><i class="fa fa-exchange-alt"></i></span>
                                    الحوالات المالية الخارجية
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/client/internalmoneytransfare') }}">
                                    <span class="icon"><i class="fa fa-exchange-alt"></i></span>
                                    الحوالات المالية الداخلية
                                </a>
                            </li>
                        </ul>
                    </li>

                <li>
                    <a href="{{ url('/client/addresses') }}">
                        <span class="icon"><i class="fas fa-map-marked-alt"></i></span>
                        عناوين الشحن
                    </a>
                </li>
            </ul>

        </nav>
        <!--    End Sidebar     -->


        <!--    Start Page Content  -->
        <div id="client-content">


            <nav class="navbar navbar-expand bg-white shadow">

                <div class="container justify-content-between">

                    <ul class="navbar-nav pr-0 flex-row">
                        <li class="nav-item">
                            <button class="navbar-toggler d-block py-0 px-1 mt-1" id="sidebarClientCollapse" type="button">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                        </li>
                    </ul>

                    <ul class="navbar-nav text-right">
                        <li class="nav-item dropdown notifications">

                            <a id="notificationsNavbarDropdown" class="nav-link dropdown-toggle text-secondary h-100 d-flex align-items-center" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="far fa-bell"></i>
                                @if($unReadNotifications->count())
                                    <span id="notifications-count" class="notifications-count">{{ $unReadNotifications->count() }}</span>
                                @endif
                            </a>

                            <div class="dropdown-menu dropdown-menu-left text-right mt-3 border-0 shadow" aria-labelledby="notificationsNavbarDropdown">

                                <div class="d-flex justify-content-between align-items-center bg-primary text-white p-3">
                                    <h6 class="font-weight-bold mb-0">الاشعارات</h6>
                                    @if($unReadNotifications->count())
                                        <a href="#" id="mark-all-notifications-as-read" class="text-white small">تحديد الكل كمقروء</a>
                                    @endif
                                </div>

                                @if($unReadNotifications->count() || ($readNotifications && $readNotifications->count()))

                                    <div id="notifications-list" class="notifications-list">

                                        @foreach ($unReadNotifications as $n)
                                            <a class="dropdown-item bg-light" href="{{ get_url_for_notifications($n) }}">
                                                {!! $n->data['title'] !!}
                                                <span class="text-muted d-block mt-1" style="font-size: 90%;">
                                                    <i class="far fa-clock mr-2"></i>
                                                    <bdi>{{ $n->created_at->diffForHumans() }}</bdi>
                                                </span>
                                            </a>
                                        @endforeach

                                        @foreach ($readNotifications as $n)
                                            <a class="dropdown-item" href="{{ get_url_for_notifications($n) }}">
                                                {!! $n->data['title'] !!}
                                                <span class="text-muted d-block mt-1" style="font-size: 90%;">
                                                    <i class="far fa-clock mr-2"></i>
                                                    <bdi>{{ $n->created_at->diffForHumans() }}</bdi>
                                                </span>
                                            </a>
                                        @endforeach

                                    </div>
                                @else
                                    <h2 class="py-4 px-2 text-muted text-center">لايوجد</h2>
                                @endif

                                <div class="text-center bg-primary text-white p-2">
                                    <a href="{{ url('client/notifications') }}" class="text-white">عرض الكل</a>
                                </div>

                            </div>

                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-secondary d-flex align-items-center" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{ authClient()->user()->name }}">
                                <img style="width: 32px" class="border rounded-circle img-profile" src="{{ authClient()->user()->getImageAvatar() }}">
                                <span class="mr-1 text-truncate pl-2 d-none d-sm-inline" style="max-width: 150px;">
                                    {{ authClient()->user()->name }}
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-left text-right mt-3 border-0 shadow" aria-labelledby="navbarDropdown">
                                {{-- <a class="dropdown-item" href="#">حسابي</a> --}}
                                <form id="logout-form" action="{{ url('client/logout') }}" method="POST">
                                    {{ csrf_field() }}
                                    <button class="dropdown-item btn" type="submit">خروج</button>
                                </form>
                            </div>
                        </li>
                    </ul>

                </div>

            </nav>


            <main class="text-right">

                @hasSection ('content-without-style')

                    @yield('content-without-style')

                @else

                    <div class="container py-5">

                        <!--    show errors if they exist   -->
                        @include('layouts.errors')

                        @yield('content')

                    </div>

                @endif

            </main>


        </div>
        <!--    End Page Content  -->


    </div>

    <!--    Button to go top    -->
    <button id="btn-go-top" title="ارجوع للأعلى" class="btn btn-dark">
        <i class="fa fa-chevron-up fa-lg fa-fw"></i>
    </button>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!--<script src="js/jquery-3.3.1.slim.min.js"></script>-->
    <script src="{{ url('/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ url('/js/popper.min.js') }}"></script>
    <script src="{{ url('/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('/js/script.js') }}"></script>
    <script>
        let change1;
        let change2;
        let change3;
        let change4;
        let change5;
    $('#mark-all-notifications-as-read').click(function(e){

        e.preventDefault();

        if($('#notifications-list .dropdown-item.bg-light').length == 0){
            return true;
        }

        /* Start send post request to server */
        $.ajax({
                url: "{{ url('client/notifications/mark-all-as-read') }}",
                dataType: 'JSON',
                method: 'POST',
                data : {'_token': '{{ csrf_token() }}'},
            })
            .done(function () { /* Form seneded success without any error */
                $('#notifications-list .dropdown-item').removeClass('bg-light');
                $('#mark-all-notifications-as-read, #notifications-count').hide();
            });
        /* End send post request to server */

    });

    </script>
    @yield('extra-js')
</body>

</html>
