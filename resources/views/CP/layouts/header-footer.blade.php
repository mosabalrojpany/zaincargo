<!doctype html>
<html lang="ar">

<head>
    <title>@yield('title',config('app.name'))</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" type="image/png" href="{{ url('images/logo.png') }}">
    <!-- Bootstrap And Fontawsome CSS -->
    <link rel="stylesheet" href="{{ url('/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ url('/css/style.css') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;900&display=swap" rel="stylesheet">
</head>

<body>


    <div class="wrapper">



        <!--    StartSidebar     -->
        <nav id="sidebar" class="text-right bg-white">

            <div id="dismiss">
                <i class="fas fa-times"></i>
            </div>
            <h5 class="mt-3 pr-2">لوحة التحكم</h5>
            <hr />

            <ul class="list-unstyled px-0">
                <li>
                    <a href="{{ url('/cp/index') }}">
                        <span class="icon"><i class="fa fa-home"></i></span>
                        الرئيسية
                    </a>
                </li>




                @if (hasRole('trips_show'))
                    <li>
                        <a href="{{ url('/cp/trips') }}">
                            <span class="icon"><i class="fa fa-plane-departure"></i></span>
                            الرحلات
                        </a>
                    </li>
                @endif

                @if (hasRole('shipping_invoices_show'))
                    <li>
                        <a href="{{ url('/cp/shipping-invoices') }}">
                            <span class="icon"><i class="fa fa-cubes"></i></span>
                            الشحنات
                        </a>
                    </li>
                @endif

                @if (hasRole('shipment_comments_show'))
                    <li>
                        <a href="{{ url('/cp/shipment-comments') }}">
                            <span class="icon"><i class="fa fa-comments"></i></span>
                            تعليقات الشحنات
                            @unless(empty($notifications->shipment_comments))
                                <span class="badge badge-primary badge-pill">{{ $notifications->shipment_comments }}</span>
                            @endunless
                        </a>
                    </li>
                @endif

                {{-- Start Customers --}}
                @if (hasRole(['customers_show', 'clients_logins']))
                    <li>
                        <a href="#subMenuCustomers" data-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle">
                            <span class="icon"><i class="fas fa-users"></i></span>
                            الزبائن
                            @unless(empty($notifications->customers))
                                <span class="badge badge-primary badge-pill">{{ $notifications->customers }}</span>
                            @endunless
                        </a>
                        <ul class="collapse list-unstyled" id="subMenuCustomers">

                            @if (hasRole('customers_show'))
                                <li>
                                    <a href="{{ url('/cp/customers') }}">
                                        <span class="icon"><i class="fas fa-users"></i></span>
                                        الزبائن
                                    </a>
                                </li>
                            @endif

                            @if (hasRole('clients_logins'))
                                <li>
                                    <a href="{{ url('/cp/clients-logins') }}">
                                        <span class="icon"><i class="fas fa-user-clock"></i></span>
                                        حركات دخول
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif
                {{-- End Customers --}}

                @if (hasRole('messages_show'))
                    <li>
                        <a href="{{ url('/cp/messages') }}">
                            <span class="icon"><i class="fa fa-comments"></i></span>
                            الرسائل
                            @unless(empty($notifications->messages))
                                <span class="badge badge-primary badge-pill">{{ $notifications->messages }}</span>
                            @endunless
                        </a>
                    </li>
                @endif

                {{-- Start Posts --}}
                @if (hasRole(['posts_show', 'tags']))
                    <li>
                        <a href="#subMenuNews" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <span class="icon"><i class="fas fa-newspaper"></i></span>
                            الأخبار
                        </a>
                        <ul class="collapse list-unstyled" id="subMenuNews">

                            @if (hasRole('posts_show'))
                                <li>
                                    <a href="{{ url('/cp/posts') }}">
                                        <span class="icon"><i class="fas fa-newspaper"></i></span>
                                        الأخبار
                                    </a>
                                </li>
                            @endif

                            @if (hasRole('tags'))
                                <li>
                                    <a href="{{ url('/cp/tags') }}">
                                        <span class="icon"><i class="fas fa-tags"></i></span>
                                        تصنيفات الأخبار
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif
                {{-- End Posts --}}


                {{-- Start Shipping settings --}}
                @if (hasRole(['addresses_show', 'shipping_companies', 'receiving_places', 'item_types']))
                    <li>
                        <a href="#subMenuShipping" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <span class="icon"><i class="fas fa-shipping-fast"></i></span>
                            إعدادت الشحن
                        </a>
                        <ul class="collapse list-unstyled" id="subMenuShipping">

                            @if (hasRole('addresses_show'))
                                <li>
                                    <a href="{{ url('/cp/addresses') }}">
                                        <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
                                        عناوين الشحن
                                    </a>
                                </li>
                            @endif

                            @if (hasRole('shipping_companies'))
                                <li>
                                    <a href="{{ url('/cp/shipping-companies') }}">
                                        <span class="icon"><i class="far fa-building"></i></span>
                                        شركات الشحن
                                    </a>
                                </li>
                            @endif

                            @if (hasRole('receiving_places'))
                                <li>
                                    <a href="{{ url('/cp/receiving-places') }}">
                                        <span class="icon"><i class="fas fa-map-marked-alt"></i></span>
                                        أماكن الاستلام
                                    </a>
                                </li>
                            @endif

                            @if (hasRole('item_types'))
                                <li>
                                    <a href="{{ url('/cp/item-types') }}">
                                        <span class="icon"><i class="fas fa-layer-group"></i></span>
                                        أنواع الأصناف
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif
                {{-- End Shipping settings --}}

                {{-- Start Users --}}
                @if (hasRole(['users', 'user_roles', 'users_logins']))
                    <li>
                        <a href="#subMenuUsers" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <span class="icon"><i class="fas fa-users-cog"></i></span>
                            المستخدمين
                        </a>
                        <ul class="collapse list-unstyled" id="subMenuUsers">

                            @if (hasRole('users'))
                                <li>
                                    <a href="{{ url('/cp/users') }}">
                                        <span class="icon"><i class="fas fa-users"></i></span>
                                        المستخدمين
                                    </a>
                                </li>
                            @endif

                            @if (hasRole('user_roles'))
                                <li>
                                    <a href="{{ url('/cp/user-roles') }}">
                                        <span class="icon"><i class="fas fa-users-cog"></i></span>
                                        أدوار المستخدمين
                                    </a>
                                </li>
                            @endif

                            @if (hasRole('users_logins'))
                                <li>
                                    <a href="{{ url('/cp/logins') }}">
                                        <span class="icon"><i class="fas fa-user-clock"></i></span>
                                        حركات الدخول
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif
                {{-- End Users --}}

                {{-- Start Settings --}}
                @if(hasRole(['branches','settings','backups_show']))
                    <li>
                        <a href="#subMenuSettings" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <span class="icon"><i class="fas fa-cogs"></i></span>
                            الإعدادت
                        </a>
                        <ul class="collapse list-unstyled" id="subMenuSettings">

                            @if (hasRole('branches'))
                                <li>
                                    <a href="{{ url('/cp/branches') }}">
                                        <span class="icon"><i class="fas fa-sitemap"></i></span>
                                        الفروع
                                    </a>
                                </li>
                            @endif

                            @if(hasRole('backups_show'))
                                <li>
                                    <a href="{{ url('/cp/backups') }}">
                                        <span class="icon"><i class="fas fa-database"></i></span>
                                        النسخ الإحتياطية
                                    </a>
                                </li>
                            @endif

                            @if(hasRole('settings'))
                                <li>
                                    <a href="{{ url('/cp/settings') }}">
                                        <span class="icon"><i class="fas fa-cog"></i></span>
                                        إعدادت الموقع
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif
                {{-- End Settings --}}

                {{-- Start Other --}}
                @if (hasRole(['faq', 'currency_types', 'countries', 'cities']))
                    <li>
                        <a href="#subMenuOther" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <span class="icon"><i class="fas fa-plus-circle"></i></span>
                            أخرى
                        </a>
                        <ul class="collapse list-unstyled" id="subMenuOther">

                            @if (hasRole('faq'))
                                <li>
                                    <a href="{{ url('/cp/faqs') }}">
                                        <span class="icon"><i class="fa fa-question-circle"></i></span>
                                        الأسئلة الشائعة
                                    </a>
                                </li>
                            @endif

                            @if (hasRole('currency_types'))
                                <li>
                                    <a href="{{ url('/cp/currency-types') }}">
                                        <span class="icon"><i class="fas fa-dollar-sign"></i></span>
                                        أنواع العملات
                                    </a>
                                </li>
                            @endif

                            @if (hasRole('countries'))
                                <li>
                                    <a href="{{ url('/cp/countries') }}">
                                        <span class="icon"><i class="fa fa-flag"></i></span>
                                        البلدان
                                    </a>
                                </li>
                            @endif

                            @if (hasRole('cities'))
                                <li>
                                    <a href="{{ url('/cp/cities') }}">
                                        <span class="icon"><i class="fa fa-city"></i></span>
                                        المدن
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif
            </ul>

        </nav>
        <!--    End Sidebar     -->


        <!--    Start Page Content  -->
        <div id="content">

            <nav class="navbar navbar-cp navbar-expand navbar-dark bg-primary">

                <div class="container">

                    <ul class="navbar-nav pr-0 flex-row">

                        <li class="nav-item">
                            <button class="navbar-toggler d-block" id="sidebarCollapse" type="button">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                        </li>

                        <li class="nav-item">
                            <a class="navbar-brand ml-2" href="{{ url('cp/index') }}">{{ config('app.name') }}</a>
                        </li>




                        @if (hasRole(['trips_show', 'trips_add']))

                            <li class="nav-item dropdown d-none d-lg-block mx-1">
                                <a class="nav-link dropdown-toggle" href="{{ url('cp/trips') }}">
                                    <span class="icon"><i class="fa fa-plane-departure"></i></span>
                                    الرحلات
                                </a>
                                <div class="dropdown-menu shadow border-0 text-right">

                                    @if (hasRole('trips_show'))
                                        <a class="dropdown-item" href="{{ url('cp/trips') }}">
                                            <span class="icon"><i class="fa fa-folder-open"></i></span> عرض
                                        </a>
                                    @endif

                                    @if (hasRole('trips_add'))
                                        <a class="dropdown-item" href="{{ url('cp/trips/create') }}">
                                            <span class="icon"><i class="fa fa-plus"></i></span> إضافة
                                        </a>
                                    @endif

                                </div>
                            </li>

                        @endif


                        @if (hasRole(['shipping_invoices_show', 'shipping_invoices_add']))

                            <li class="nav-item dropdown d-none d-lg-block mx-1">
                                <a class="nav-link dropdown-toggle" href="{{ url('cp/shipping-invoices') }}">
                                    <span class="icon"><i class="fa fa-cubes"></i></span>
                                    الشحنات
                                </a>
                                <div class="dropdown-menu shadow border-0 text-right">

                                    @if (hasRole('shipping_invoices_show'))
                                        <a class="dropdown-item" href="{{ url('cp/shipping-invoices') }}">
                                            <span class="icon"><i class="fa fa-folder-open"></i></span> عرض
                                        </a>
                                    @endif

                                    @if (hasRole('shipping_invoices_add'))
                                        <a class="dropdown-item" href="{{ url('cp/shipping-invoices/create') }}">
                                            <span class="icon"><i class="fa fa-plus"></i></span> إضافة
                                        </a>
                                    @endif
                                </div>
                            </li>

                        @endif


                        @if (hasRole('customers_show'))

                            <li class="nav-item d-none d-lg-block mx-1">
                                <a class="nav-link" href="{{ url('cp/customers') }}">
                                    <span class="icon"><i class="fa fa-users"></i></span>
                                    الزبائن
                                </a>
                            </li>

                        @endif

                    </ul>

                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                v-pre>{{ auth()->user()->name }}<span class="caret"></span>
                            </a>
                            <div class="dropdown-menu border-0 shadow dropdown-menu-left"
                                aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ url('/') }}" target="_blank">
                                    <span class="icon"><i class="fas fa-globe"></i></span>
                                    زيارة الموقع
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal"
                                    data-target="#editPasswordUserModal">
                                    <span class="icon"><i class="fas fa-lock"></i></span>
                                    تغير كلمة المرور
                                </a>
                                <div class="dropdown-divider"></div>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    {{ csrf_field() }}
                                    <button class="dropdown-item btn" type="submit">
                                        <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
                                        خروج
                                    </button>
                                </form>
                            </div>
                        </li>
                    </ul>

                </div>

            </nav>




            @hasSection ('content-without-style')

                @yield('content-without-style')

            @else

                <div class="container my-5">

                    <!--    show errors if they exist   -->
                    @include('layouts.errors')

                    @yield('content')

                </div>

            @endif


        </div>
        <!--    End Page Content  -->



        <!--    Start Modal editPasswordUserModal -->
        <div class="modal fade" id="editPasswordUserModal" tabindex="-1" role="dialog"
            aria-labelledby="editPasswordUserModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPasswordUserModalLabel">تغير كلمة المرور</h5>
                        <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class='formSendAjaxRequest was-validated' action="{{ url('/cp/user/current/edit/password') }}"
                        refresh-seconds="2" method="post">
                        <div class="modal-body">
                            <div class="formResult text-center"></div>
                            {{ csrf_field() }}

                            <div class="form-group row">
                                <label for="inputCurrentPasswordUser" class="col-md-4 col-form-label text-right">كلمة
                                    المرور الحالية</label>
                                <div class="col-md-7 pr-md-0">
                                    <input id="inputCurrentPasswordUser" type="password" pattern="\s*([^\s]\s*){6,32}"
                                        class="form-control" name="current_password" placeholder="كلمة المرور الحالية"
                                        required>
                                    <div class="invalid-feedback text-center">
                                        @lang('validation.between.string',['attribute'=>'كلمة المرور','min'=> 6
                                        ,'max'=>32])</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputPasswordUser" class="col-md-4 col-form-label text-right">كلمة المرور
                                    الجديدة</label>
                                <div class="col-md-7 pr-md-0">
                                    <input id="inputPasswordUser" type="password" name="password"
                                        pattern="\s*([^\s]\s*){6,32}" class="form-control inputPassword"
                                        target-input="#inputPasswordUserConfirmation" placeholder="كلمة المرور الجديدة"
                                        required>
                                    <div class="invalid-feedback text-center">
                                        @lang('validation.between.string',['attribute'=>'كلمة المرور','min'=> 6
                                        ,'max'=>32])</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputPasswordUserConfirmation"
                                    class="col-md-4 col-form-label text-right">تأكيد كلمة المرور</label>
                                <div class="col-md-7 pr-md-0">
                                    <input id="inputPasswordUserConfirmation" type="password"
                                        name="password_confirmation" pattern="\s*([^\s]\s*){6,32}" class="form-control"
                                        placeholder="تأكيد كلمة المرور الجديدة" required>
                                    <div class="invalid-feedback text-center">يجب أن تكون كلمات المرور متساوية</div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">تحديث</button>
                            <button type="button" class="btn btn-danger mr-2" data-dismiss="modal">إلغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--    End Modal editPasswordUserModal -->


        <!-- Dark Overlay element -->
        <div class="overlay"></div>

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
    <script src="{{ url('/js/script1.js') }}"></script>
    @yield('extra-js')
</body>

</html>
