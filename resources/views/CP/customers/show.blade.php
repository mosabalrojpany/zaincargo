@extends('CP.layouts.header-footer')
@section('content-without-style')



{{--  Start main section   --}}
<div class="py-4 text-center bg-white">

    <a target="_blank" href="{{ $customer->getImage() }}">
        <img src="{{ $customer->getImageAvatar() }}" alt="image" class="avatar-customer mb-2">
    </a>
    <h3><bdi>{{ $customer->name }}</bdi></h3>
    <div class="text-secondary d-flex align-items-center justify-content-center">
        <i class="fa fa-address-card ml-1 mr-3"></i>
        <bdi>{{ $customer->code }}</bdi>
        <i class="fa fa-phone ml-1 mr-3"></i>
        <bdi>{{ $customer->phone }}</bdi>
    </div>

</div>
{{--  End main section   --}}



<!--    Start menu or header tabs (navs)    -->
<div class="bg-light">
    <div class="container d-flex justify-content-between">
        <ul class="nav nav-tabs my-nav-tabs border-bottom-0 pr-0" role="tablist">
            <li class="nav-item">
                <a class="nav-link py-3 text-dark active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">
                    <i class="fa fa-user-alt fa-sm ml-1"></i><span class="">الملف الشخصي</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-3 text-dark" id="shipping-invoices-tab" data-toggle="tab" href="#shipping" role="tab" aria-controls="shipping" aria-selected="false">
                    <i class="fa fa-shipping-fast fa-sm ml-1"></i><span class="">الشحنات</span>
                </a>
            </li>
            @if($customer->wallet)
            <li class="nav-item">
                <a class="nav-link py-3 text-dark" id="shipping-invoices-tab" data-toggle="tab" href="#wallet" role="tab" aria-controls="shipping" aria-selected="false">
                    <i class="fa fa-shipping-fast fa-sm ml-1"></i><span class="">المحفظة</span>
                </a>
            </li>
            @endif
            <li class="nav-item">
                <a class="nav-link py-3 text-dark" id="purchase-orders-tab" data-toggle="tab" href="#purchase" role="tab" aria-controls="purchase" aria-selected="false">
                    <i class="fa fa-shopping-cart fa-sm ml-1"></i><span class="">فواتير الشراء</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-3 text-dark" id="logins-tab" data-toggle="tab" href="#logins" role="tab" aria-controls="logins" aria-selected="false">
                    <i class="far fa-clock fa-sm ml-1"></i><span class="">حركات الدخول</span>
                </a>
            </li>
        </ul>
        <div class="d-flex align-items-center">

            @if(hasRole('customers_edit'))
                <button class="btn btn-primary btn-sm ml-1" data-toggle="modal" data-target="#editModal">
                    <i class="fas fa-pen"></i> تعديل
                </button>
            @endif



            @if(hasRole('merchant_from_customer'))
            <button @if($customer->merchant_state == 1)class="btn btn-danger btn-sm ml-1"
                 @else class="btn btn-primary btn-sm ml-1"
                  @endif
                   data-toggle="modal" data-target="#merchant">
                   <i class="fas"></i>
                   @if($customer->merchant_state == 1) الغاء ميزة التاجر
                    @else اضافة ميزة التاجر
                     @endif </button>
        @endif




            @if($customer->state == 1)

                @if(hasRole('customers_delete'))
                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal">
                        <i class="far fa-trash-alt"></i> حذف
                    </button>
                @endif


            @else
                @if(hasRole('customers_edit'))
                    <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#editPasswordModal">
                        <i class="fas fa-lock"></i> تغير كلمة المرور
                    </button>
                @endif

            @endif

        </div>
    </div>
</div>
<!--    End menu or header tabs (navs)    -->


<!--    Start content tabs (navs)   -->
<div class="container my-5">


    <div class="tab-content">

        <!--    Start profile      -->
        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">

            <div class="row my-5">

                <div class="col-lg-8">

                    <!--    Start about customer   -->
                    <div class="card border-0">
                        <div class="card-header bg-white py-3 d-flex justify-content-between" role="tab" id="headingProfile">
                            <h5 class="mb-0">
                                معلومات الشخصية
                            </h5>
                            <a data-toggle="collapse" class="text-dark" href="#collapseProfile" aria-expanded="true" aria-controls="collapseProfile">
                                <i class="fa fa-chevron-down"></i>
                            </a>
                        </div>

                        <div id="collapseProfile" class="collapse show" role="tabpanel" aria-labelledby="headingProfile">
                            <div class="card-body">
                                <div class="row text-right bg-white">
                                    <div class="col-sm-6 mb-3">
                                        <div class="row">
                                            <label class="col-auto w-150px">رقم العضوية</label>
                                            <div class="col text-secondary"><bdi>{{ $customer->code }}</bdi></div>
                                        </div>
                                        <div class="border-b mb-1"></div>
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <div class="row">
                                            <label class="col-auto w-150px">الاسم</label>
                                            <div class="col text-secondary">{{ $customer->name }}</div>
                                        </div>
                                        <div class="border-b mb-1"></div>
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <div class="row">
                                            <label class="col-auto w-150px">رقم الهاتف</label>
                                            <bdi class="col text-secondary">{{ $customer->phone }}</bdi>
                                        </div>
                                        <div class="border-b mb-1"></div>
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <div class="row">
                                            <label class="col-auto w-150px">البريد الإلكتروني</label>
                                            <div class="col text-secondary">{{ $customer->email }}</div>
                                        </div>
                                        <div class="border-b mb-1"></div>
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <div class="row">
                                            <label class="col-auto w-150px">العنوان</label>
                                            <div class="col text-secondary">{{ $customer->address }}</div>
                                        </div>
                                        <div class="border-b mb-1"></div>
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <div class="row">
                                            <label class="col-auto w-150px">استلام في</label>
                                            <div class="col text-secondary">{{ $customer->recivePlace->name }}</div>
                                        </div>
                                        <div class="border-b mb-1"></div>
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <div class="row">
                                            <label class="col-auto w-150px">ملف التحقق</label>
                                            <div class="col text-secondary">
                                                <a target="_blank" href="{{ $customer->getVerificationFile() }}">ملف إتبات الهوية</a>
                                            </div>
                                        </div>
                                        <div class="border-b mb-1"></div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <label class="col-auto w-150px">معلومات أخرى</label>
                                            <div class="col text-secondary">{{ $customer->extra }}</div>
                                        </div>
                                        <div class="border-b mb-1"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--    End about customer   -->

                </div>

                <!--    Start info about account     -->
                <div class="col-lg-4 mt-3 mt-lg-0 text-right">
                    <div class="card border-0">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">معلومات الحساب</h5>
                        </div>
                        <div class="p-2">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td class="text-right">الحالة</td>
                                        <td>
                                            <span class='text-white px-2 py-1 label-state {{ $customer->getStateColor() }}'>{{ $customer->getState() }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">تاريخ الإنضمام</td>
                                        <td><bdi title="{{$customer->created_at->format('Y-m-d g:ia')}}">{{$customer->created_at->diffForHumans()}}</bdi></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">تاريخ القبول</td>
                                        <td>
                                            @if($customer->activated_at)
                                                <bdi title="{{ $customer->activated_at->format('Y-m-d g:ia') }}">{{ $customer->activated_at->diffForHumans() }}</bdi>
                                            @else
                                                <bdi class="bg-secondary text-white px-2 py-1">لم يفعل بعد</bdi>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">أخر وصول</td>
                                        <td>
                                            @if($customer->last_access)
                                                <bdi title="{{ $customer->last_access->format('Y-m-d g:ia') }}">{{ $customer->last_access->diffForHumans() }}</bdi>
                                            @else
                                            <bdi class="bg-secondary text-white px-2 py-1">لم يدخل بعد</bdi> @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--    End info about account     -->

            </div>

        </div>
        <!--    End profile      -->

        <!--    Start shipping-invoices      -->
        <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">

            <div class="row">

                <!--     Start show invoices     -->
                <div class="col-lg-8">

                    <div class="card-header bg-white py-3 text-right">
                        <h5 class="mb-0">أخر (10) فواتير</h5>
                    </div>

                    @if($shippingInvoices)

                        <!--    Start show invoices   -->
                        <div class="card-body px-1 pb-1 pt-0 bg-white">
                            <table class="table table-center table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">رقم الفاتورة</th>
                                        <th scope="col">رقم الرحلة</th>
                                        <th scope="col">رمز الشحنة</th>
                                        <th scope="col">تاريخ الإضافة</th>
                                        <th scope="col">إجمالي التكلفة</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <!-- Start print invoices -->
                                    @foreach($shippingInvoices as $invoice)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td><a target="_blank" href="{{ url('cp/shipping-invoices',$invoice->id) }}">{{ $invoice->id }}</a></td>
                                            <td>
                                                @if($invoice->trip_id)
                                                <a href="{{ url('cp/trips',$invoice->trip_id) }}">{{ $invoice->trip_number() }}</a>
                                                @else
                                                -----
                                                @endif
                                            </td>
                                            <td>{{ $invoice->shipment_code }}</td>
                                            <td title="{{  $invoice->created_at() }}">
                                                <bdi>{{ $invoice->created_at->diffForHumans() }}</bdi>
                                            </td>
                                            <td>{!! $invoice->total_cost() !!}</td>
                                        </tr>
                                    @endforeach
                                    <!-- End print invoices -->

                                </tbody>
                            </table>
                        </div>
                        <!--    End show invoices   -->

                    @else

                        <h1 class="text-center text-secondary py-5">لا توجد نتائج</h1>

                    @endif

                </div>
                <!--    End show invoices       -->


                <!--    Start info about shipping-invoices     -->
                <div class="col-lg-4 mt-3 mt-lg-0 text-right">
                    <div class="card border-0">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">إحصائيات الشحنات</h5>
                        </div>
                        <div class="p-2">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td class="text-right">تم الاستلام</td>
                                        <td>{{ $shipping_statistics->warehouse }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">بانتظار الشحن</td>
                                        <td>{{ $shipping_statistics->waitting_shipping }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">تم الشحن</td>
                                        <td>{{ $shipping_statistics->on_the_way }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">وصلت</td>
                                        <td>{{ $shipping_statistics->arrived }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">تم التسليم</td>
                                        <td>{{ $shipping_statistics->received }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right w-150px">المعاملات المالية</td>
                                        <td class="font-weight-bold">{{ number_format($shipping_statistics->transactions) }} {{ app_settings()->currency->sign }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--    End info about shipping-invoices       -->

            </div>

        </div>
        <!--    End shipping-invoices      -->
        @if($customer->wallet)
        <!--    Start wallet      -->
                <div class="tab-pane fade" id="wallet" role="tabpanel" aria-labelledby="shipping-tab">

                    <div class="row">

                        <!--     Start show invoices     -->
                        <div class="col-lg-8">

                            <div class="card-header bg-white py-3 text-right">
                                <h5 class="mb-0"> المحفظة</h5>
                            </div>


                                <!--    Start show invoices   -->
                                <div class="card-body px-1 pb-1 pt-0 bg-white">
                                    <table class="table table-center table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">محفظة الزبون</th>
                                                <th scope="col">طرابلس LY</th>
                                                <th scope="col">طرابلس $ </th>
                                                <th scope="col">بنغازي LY</th>
                                                <th scope="col">بنغازي $</th>
                                                <th scope="col">مصراته LY</th>
                                                <th scope="col">مصراته $</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <!-- Start print invoices -->
                                                <tr>
                                                    <td style="background-color: white;"><a target="_blank" href="{{ url('cp/wallet/show',$customer->wallet->id) }}">{{ $customer->code }}</a></td>
                                                    <td style="background-color: white;">{{ $customer->wallet->money_denar_t }}</td>
                                                    <td style="background-color: white;">{{ $customer->wallet->money_dolar_t }}</td>
                                                    <td style="background-color: white;">{{ $customer->wallet->money_denar_b }}</td>
                                                    <td style="background-color: white;">{{ $customer->wallet->money_dolar_b }}</td>
                                                    <td style="background-color: white;">{{ $customer->wallet->money_denar_m }}</td>
                                                    <td style="background-color: white;">{{ $customer->wallet->money_dolar_m }}</td>
                                                </tr>
                                            <!-- End print invoices -->

                                        </tbody>
                                    </table>
                                </div>
                                <!--    End show invoices   -->
                        </div>
                        <!--    End show invoices       -->




                    </div>

                </div>
        <!--    End wallet      -->
        @endif

        <!--    Start Purchase-orders      -->
        <div class="tab-pane fade" id="purchase" role="tabpanel" aria-labelledby="purchase-tab">

            <div class="row">

                <!--     Start show Purchase-Orders     -->
                <div class="col-lg-8">

                    <div class="card-header bg-white py-3 text-right">
                        <h5 class="mb-0">أخر (10) طلبات</h5>
                    </div>

                    @if($orders)

                        <!--    Start show Purchase-Orders   -->
                        <div class="card-body px-1 pb-1 pt-0 bg-white">
                            <table class="table table-center table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">رقم الطلب</th>
                                        <th scope="col">الحالة</th>
                                        <th scope="col">عمولة الشراء</th>
                                        <th scope="col">إجمالي التكلفة</th>
                                        <th scope="col">تاريخ الطلب</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <!-- Start print Purchase-Orders -->
                                    @foreach($orders as $order)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td><a target="_blank" href="{{ url('cp/purchase-orders',$order->id) }}">{{ $order->id }}</a></td>
                                            <td>{{ $order->getState() }}</td>
                                            <td>{{ $order->getFee() }}</td>
                                            <td>{{ $order->getTotalCostByCurrency() }}</td>
                                            <td title="{{ $order->created_at() }}">
                                                <bdi>{{ $order->created_at->diffForHumans() }}</bdi>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <!-- End print Purchase-Orders -->

                                </tbody>
                            </table>
                        </div>
                        <!--    End show Purchase-Orders   -->

                    @else

                        <h1 class="text-center text-secondary py-5">لا توجد نتائج</h1>

                    @endif

                </div>
                <!--    End show Purchase-Orders       -->


                <!--    Start info about Purchase-orders     -->
                <div class="col-lg-4 mt-3 mt-lg-0 text-right">
                    <div class="card border-0">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">إحصائيات طلبات الشراء</h5>
                        </div>
                        <div class="p-2">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td class="text-right">جديد</td>
                                        <td>{{ $orders_statistics->new }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">قيد المراجعة</td>
                                        <td>{{ $orders_statistics->review }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">مرفوض</td>
                                        <td>{{ $orders_statistics->rejected }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">بانتظار الدفع</td>
                                        <td>{{ $orders_statistics->waitting_pay }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">تم الدفع</td>
                                        <td>{{ $orders_statistics->paid }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">مكتمل</td>
                                        <td>{{ $orders_statistics->done }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right w-150px">إجمالي العمولة</td>
                                        <td class="font-weight-bold">{{ number_format($orders_statistics->fee) }} {{ app_settings()->currency->sign }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right w-150px">المعاملات المالية</td>
                                        <td class="font-weight-bold">{{ number_format($orders_statistics->total_cost) }} {{ app_settings()->currency->sign }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--    End info about Purchase-orders       -->

            </div>

        </div>
        <!--    End Purchase-orders      -->



        <!--    Start Logins      -->
        <div class="tab-pane fade" id="logins" role="tabpanel" aria-labelledby="logins-tab">

            <div class="card border-0 shadow mt-5">
                <div class="card-header text-right bg-white py-3">
                    <h5 class="mb-0">أخر حركات دخول</h5>
                </div>
                <div class="card-body pt-0 px-0">

                    @empty($customer->lastLogins)
                        <h1 class="text-center text-secondary py-5">لا توجد سجلات دخول</h1>
                    @else
                        <table class="table text-center table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">نظام التشغيل</th>
                                    <th scope="col">المتصفح</th>
                                    <th scope="col">البلد</th>
                                    <th scope="col">المدينة</th>
                                    <th scope="col">ip</th>
                                    <th scope="col">الدخول</th>
                                    <th scope="col">أخر وصول</th>
                                </tr>
                            </thead>
                            <tbody>

                                <!-- Start print logins -->
                                @foreach($customer->lastLogins as $login)
                                    <tr>
                                        <th scope="row">{{1+$loop->index}}</th>
                                        <td>{{ $login->os}}</td>
                                        <td>{{ $login->browser}}</td>
                                        <td>{{ $login->country}}</td>
                                        <td>{{ $login->city}}</td>
                                        <td>{{ $login->ip}}</td>
                                        <td class="dateTiemAgo" data-datetime="{{ $login->log_in}}"><bdi>{{ $login->log_in->format('Y-m-d g:ia')}}</bdi></td>
                                        <td class="dateTiemAgo" data-datetime="{{ $login->log_out}}"><bdi>{{ $login->log_out->format('Y-m-d g:ia')}}</bdi></td>
                                    </tr>
                                @endforeach
                                <!-- End print logins -->

                            </tbody>
                        </table>
                    @endempty
                </div>
            </div>

        </div>
        <!--    End Logins      -->


    </div>

</div>
<!--    End content tabs (navs)   -->



<!--    Start Modal editModal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">تعديل معلومات زبون</h5>
                <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class='formSendAjaxRequest was-validated' redirect-to="{{ Request::url() }}" refresh-seconds='2' upload-files='true' focus-on='#editModalLabel' action="{{ url('/cp/customers/edit') }}" enctype="multipart/form-data" method="post">
                <div class="modal-body px-5">

                    <div class="alert alert-warning text-right">
                        ملف التحقق اتركه فارغ إذا لاتريد تغيره
                    </div>
                    <div class="formResult text-center"></div>

                    <div class="row">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $customer->id }}" />
                        <div class="col-lg-6 text-center pb-2">
                            <div class="image-upload">
                                <label class="m-0 img-box avatar-customer">
                                    <img src="{{ $customer->getImage() }}" default-img="{{ $customer->getImage() }}" class="w-100 h-100 rounded-circle">
                                </label>
                                <input class="form-control img-input" type="file" name="img" accept=".png,.jpg,.jpeg,.gif">
                                <div class="invalid-feedback text-center">@lang("validation.mimes",[ "attribute"=>"","values" => "png,jpg,jpeg,gif"])</div>
                            </div>
                        </div>
                        <div class="col-md-6 pt-3">
                            <div class="form-group row">
                                <label for="inputName" class="col-auto w-150px col-form-label text-right">الاسم</label>
                                <div class="col pr-md-0">
                                    <input type="text" name="name" id="inputName" class="form-control" value="{{ $customer->name }}" pattern="\s*([^\s]\s*){3,32}" required>
                                    <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'الاسم','min'=> 3 ,'max'=>32])</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPhone" class="col-auto w-150px col-form-label text-right">رقم الهاتف</label>
                                <div class="col pr-md-0">
                                    <input type="text" name="phone" id="inputPhone" class="form-control text-right" dir='ltr' value="{{ $customer->phone }}" pattern="\s*([0-9\-\+]\s*){3,14}" required>
                                    <div class="invalid-feedback text-center">@lang('validation.digits_between',['attribute'=>'رقم الهاتف','min'=> 3 ,'max'=>14])</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="inputAddress" class="col-auto w-150px col-form-label text-right">العنوان</label>
                                <div class="col pr-md-0">
                                    <input type="text" name="address" id="inputAddress" class="form-control" value="{{ $customer->address }}" pattern="\s*([^\s]\s*){3,64}" required>
                                    <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'العنوان','min'=> 3 ,'max'=>64])</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="inputReceiveIn" class="col-auto w-150px col-form-label text-right">استلام في</label>
                                <div class="col pr-md-0">
                                    <select id="inputReceiveIn" class="form-control setValue" value="{{ $customer->receive_in }}" name="receive_in" required>
                                        @foreach($receivingPlaces as $place)
                                            <option value="{{ $place->id }}">{{ $place->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback text-center">@lang('validation.required',['attribute'=>'المكان'])</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="inputEmail" class="col-auto w-150px col-form-label text-right">البريد الإلكتروني</label>
                                <div class="col pr-md-0">
                                    <input id="inputEmail" type="email" class="form-control" value="{{ $customer->email }}" name="email" required>
                                    <div class="invalid-feedback text-center">@lang('validation.required',['attribute'=>'البريد الإلكتروني'])</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="inputState" class="col-auto w-150px col-form-label text-right">الحالة</label>
                                <div class="col pr-md-0">
                                    <select id="inputState" name="state" class="form-control setValue" value="{{ $customer->state == 1 ? 2 : $customer->state }}" required>
                                            <option value="3">تفعيل</option>
                                            <option value="2">إيقاف</option>
                                        </select>
                                    <div class="invalid-feedback text-center">يجب تحديد الحالة</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-auto w-150px col-form-label text-right">ملف التحقق</label>
                                <div class="col pr-md-0">
                                    <div class="custom-file">
                                        <input type="file" name="verification_file" class="custom-file-input" id="customFileInput" accept=".jpeg, .png, .jpg, .gif, .pdf">
                                        <label class="custom-file-label" for="customFileInput">اختر ملف</label>
                                        <div class="invalid-feedback text-center">@lang('validation.mimes',[ 'attribute'=>'ملف التحقق','values' => 'jpeg,png,jpg,gif,pdf'])</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group row">
                                <label for="inputExtra" class="col-auto w-150px col-form-label text-right">أخرى</label>
                                <div class="col pr-md-0">
                                    <textarea name="extra" id="inputExtra" maxlength="500" rows="4" class="form-control">{{ $customer->extra }}</textarea>
                                    <div class="invalid-feedback text-center">@lang('validation.max.string',['attribute'=>'معلومات أخرى','max'=>500])</div>
                                </div>
                            </div>
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
<!--    End Modal editModal -->

@if(hasRole('merchant_from_customer'))
<!--Start Modal Merchant MODAL -->
        <div class="modal fade" id="merchant" tabindex="-1" role="dialog" aria-labelledby="merchantModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        @if($customer->merchant_state==0)
                        <h5 class="modal-title" id="deleteModalLabel">اضافة ميزة التاجر للزبون</h5>
                        @else
                        <h5 class="modal-title" id="deleteModalLabel">الغاء ميزة التاجر للزبون</h5>
                        @endif
                        <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form class='formSendAjaxRequest'  refresh-seconds='2' action="{{ url('/cp/addMerchant') }}"
                        method="post">
                        <div class="modal-body text-right">
                            <div class="formResult text-center"></div>
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $customer->id }}" />
                            @if($customer->merchant_state==0)
                            هل أنت متأكد أنك تريد اضافة الميزة لهدا الزبون  ؟
                            @else
                            هل أنت متأكد أنك تريد الغاء الميزة لهدا الزبون  ؟
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">تحديث</button>
                            <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">إلغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
<!--    End Modal Merchant MODAL -->
@endif


@if($customer->state == 1)

    @if(hasRole('customers_delete'))
        <!--    Start Modal deleteModal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">حذف زبون</h5>
                        <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form class='formSendAjaxRequest' redirect-to='{{ url('/cp/customers') }}' refresh-seconds='2' action="{{ url('/cp/customers') }}"
                        method="post">
                        <div class="modal-body text-right">
                            <div class="formResult text-center"></div>
                            @method('DELETE')
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $customer->id }}" />
                            هل أنت متأكد أنك تريد حذف الزبون ؟
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">حذف</button>
                            <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">إلغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--    End Modal deleteModal -->
    @endif

@else


    @if(hasRole('customers_edit'))
        <!--    Start Modal editPasswordModal -->
        <div class="modal fade" id="editPasswordModal" tabindex="-1" role="dialog" aria-labelledby="editPasswordModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPasswordModalLabel">تغير كلمة المرور</h5>
                        <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class='formSendAjaxRequest was-validated' action="{{ url('/cp/customers/edit/password') }}" method="post">
                        <div class="modal-body">
                            <div class="formResult text-center"></div>
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $customer->id }}" />

                            <div class="form-group row">
                                <label for="inputPassword" class="col-md-4 col-form-label text-right">كلمة المرور الجديدة</label>
                                <div class="col-md-7 pr-md-0">
                                    <input id="inputPassword" type="password" minlength="6" maxlength="32" class="form-control" name="password" placeholder="كلمة المرور الجديدة" required>
                                    <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'كلمة المرور','min'=> 6 ,'max'=>32])</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputPasswordConfirmation" class="col-md-4 col-form-label text-right">تأكيد كلمة المرور</label>
                                <div class="col-md-7 pr-md-0">
                                    <input id="inputPasswordConfirmation" type="password" minlength="6" maxlength="32" class="form-control" placeholder="تأكيد كلمة المرور الجديدة" name="password_confirmation"
                                        required>
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
        <!--    End Modal editPasswordModal -->
    @endif

@endif


@endsection
