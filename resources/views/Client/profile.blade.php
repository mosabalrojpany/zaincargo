@extends('Client.layouts.app')


@section('content')



    <!--    Start header    -->
    <h4 class="font-weight-bold">الرئيسية</h4>
    <!--    End header    -->


    <div class="row my-4">


        {{-- Start user info --}}
        <aside class="col-lg-4 text-center">

            {{-- Start edit user --}}
            <div class="card border-0 shadow text-center mb-3">
                <img class="rounded-circle img-thumbnail avatar-customer mx-auto my-3" src="{{ authClient()->user()->getImageAvatar() }}" />
                <h4 class="card-title">
                    <bdi>{{ authClient()->user()->code }}</bdi>
                </h4>
                <div class="card-footer bg-white">
                    <a href="#" class="text-decoration-none" data-toggle="modal" data-target="#editModal">
                        <i class="fa fa-sliders-h"></i>
                        تعديل الحساب
                    </a>
                </div>
            </div>
            {{-- Start edit user --}}

            {{-- Start info card --}}
            <div class="card border-0 shadow text-right mb-3">
                <h4 class="card-header bg-white">معلوماتي</h4>
                <ul class="list-group list-group-flush pr-0">
                    <li class="list-group-item" title="رقم العضوية">
                        <span class="text-secondary icon-item">
                            <i class="fa fa-id-card" aria-hidden="true"></i>
                        </span>
                        <bdi>{{ authClient()->user()->code }}</bdi>
                    </li>
                    <li class="list-group-item" title="الاسم">
                        <span class="text-secondary icon-item">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </span>
                        {{ authClient()->user()->name }}
                    </li>
                    <li class="list-group-item" title="البريد الإلكتروني">
                        <span class="text-secondary icon-item">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                        {{ authClient()->user()->email }}
                    </li>
                    <li class="list-group-item" title="رقم الهاتف">
                        <span class="text-secondary icon-item">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                        </span>
                        <bdi>{{ authClient()->user()->phone }}</bdi>
                    </li>
                    <li class="list-group-item" title="العنوان">
                        <span class="text-secondary icon-item">
                            <i class="fa fa-map-marker-alt" aria-hidden="true"></i>
                        </span>
                        {{ authClient()->user()->address }}
                    </li>
                    <li class="list-group-item" title="مكان استلام الشحنات">
                        <span class="text-secondary icon-item">
                            <i class="fa fa-shipping-fast" aria-hidden="true"></i>
                        </span>
                        {{ authClient()->user()->recivePlace->name }}
                    </li>
                    
                </ul>
            </div>
            {{-- Edit info card --}}

        </aside>
        {{-- End user info --}}


        {{-- Start statistics cards --}}
        <section class="col-lg-8">

            {{-- Start shipping invoices --}}
            <div class="card statistics-card shadow text-center border-0 mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h4 class="mt-3">
                                <a class="text-dark text-decoration-none" href="{{ url('client/shipping-invoices') }}">الشحنات</a>
                            </h4>
                            <h5 class="statistics-card-count">
                                <a class="text-dark text-decoration-none" href="{{ url('client/shipping-invoices') }}">{{ $shipping->total }}</a>
                            </h5>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6 my-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="f-15px">تم الاستلام</span>
                                        <span class="f-15px">{{ $shipping->warehouse }}</span>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ $shipping->percentage_warehouse }}%;" aria-valuenow="{{ $shipping->percentage_warehouse }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="f-15px">بإنتظار الشحن</span>
                                        <span class="f-15px">{{ $shipping->waitting_shipping }}</span>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ $shipping->percentage_waitting_shipping }}%;" aria-valuenow="{{ $shipping->percentage_waitting_shipping }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="f-15px">تم الشحن</span>
                                        <span class="f-15px">{{ $shipping->on_the_way }}</span>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ $shipping->percentage_on_the_way }}%;" aria-valuenow="{{ $shipping->percentage_on_the_way }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="f-15px">وصلت</span>
                                        <span class="f-15px">{{ $shipping->arrived }}</span>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ $shipping->percentage_arrived }}%;" aria-valuenow="{{ $shipping->percentage_arrived }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="f-15px">تم التسليم</span>
                                        <span class="f-15px">{{ $shipping->received }}</span>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $shipping->percentage_received }}%;" aria-valuenow="{{ $shipping->percentage_received }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End shipping invoices --}}

            {{-- Start purchase orders --}}
            <div class="card statistics-card shadow text-center border-0 mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h4 class="mt-3">
                                <a class="text-dark text-decoration-none" href="{{ url('client/purchase-orders') }}">طلبات الشراء</a>
                            </h4>
                            <h5 class="statistics-card-count">
                                <a class="text-dark text-decoration-none" href="{{ url('client/purchase-orders') }}">{{ $orders->total }}</a>
                            </h5>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6 my-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="f-15px">جديد</span>
                                        <span class="f-15px">{{ $orders->new }}</span>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ $orders->percentage_new }}%;" aria-valuenow="{{ $orders->percentage_new }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="f-15px">قيد المراجعة</span>
                                        <span class="f-15px">{{ $orders->review }}</span>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ $orders->percentage_review }}%;" aria-valuenow="{{ $orders->percentage_review }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="f-15px">مرفوض</span>
                                        <span class="f-15px">{{ $orders->rejected }}</span>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $orders->percentage_rejected }}%;" aria-valuenow="{{ $orders->percentage_rejected }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="f-15px">بإنتظار الدفع</span>
                                        <span class="f-15px">{{ $orders->waitting_pay }}</span>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ $orders->percentage_waitting_pay }}%;" aria-valuenow="{{ $orders->percentage_waitting_pay }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="f-15px">تم الدفع</span>
                                        <span class="f-15px">{{ $orders->paid }}</span>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ $orders->percentage_paid }}%;" aria-valuenow="{{ $orders->percentage_paid }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="f-15px">مكتمل</span>
                                        <span class="f-15px">{{ $orders->done }}</span>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $orders->percentage_done }}%;" aria-valuenow="{{ $orders->percentage_done }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End purchase orders --}}

            {{-- Start money transfers --}}
            <div class="card statistics-card shadow text-center border-0 mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h4 class="mt-3">
                                <a class="text-dark text-decoration-none" href="{{ url('client/money-transfers') }}">الحوالات المالية</a>
                            </h4>
                            <h5 class="statistics-card-count">
                                <a class="text-dark text-decoration-none" href="{{ url('client/money-transfers') }}">{{ $transfers->total }}</a>
                            </h5>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6 my-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="f-15px">جديد</span>
                                        <span class="f-15px">{{ $transfers->new }}</span>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ $transfers->percentage_new }}%;" aria-valuenow="{{ $transfers->percentage_new }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="f-15px">قيد المراجعة</span>
                                        <span class="f-15px">{{ $transfers->review }}</span>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ $transfers->percentage_review }}%;" aria-valuenow="{{ $transfers->percentage_review }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="f-15px">مرفوض</span>
                                        <span class="f-15px">{{ $transfers->rejected }}</span>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $transfers->percentage_rejected }}%;" aria-valuenow="{{ $transfers->percentage_rejected }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="f-15px">بإنتظار الدفع</span>
                                        <span class="f-15px">{{ $transfers->waitting_pay }}</span>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ $transfers->percentage_waitting_pay }}%;" aria-valuenow="{{ $transfers->percentage_waitting_pay }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="f-15px">بإنتظار الاستلام</span>
                                        <span class="f-15px">{{ $transfers->waitting_receive }}</span>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ $transfers->percentage_waitting_receive }}%;" aria-valuenow="{{ $transfers->percentage_waitting_receive }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="f-15px">مكتمل</span>
                                        <span class="f-15px">{{ $transfers->done }}</span>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $transfers->percentage_done }}%;" aria-valuenow="{{ $transfers->percentage_done }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End money transfers --}}

        </section>
        {{-- End statistics cards --}}

    </div>



<!--    Start Modal editModal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">تعديل معلومات الحساب</h5>
                <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class='formSendAjaxRequest was-validated' refresh-seconds='2' upload-files='true' focus-on='#editModalLabel' action="{{ url('/client/profile/update') }}" enctype="multipart/form-data" method="post">
                <div class="modal-body px-5">

                    <div class="alert alert-warning text-right">
                        اترك كلمة المرور فارغة إذا كنت لاتريد تغيرها
                    </div>

                    <div class="formResult text-center"></div>

                    <div class="w-100">

                        {{ csrf_field() }}

                        <div class="text-center pb-3">
                            <div class="image-upload">
                                <label class="m-0 img-box avatar-customer">
                                    <img src="{{ authClient()->user()->getImage() }}" default-img="{{ authClient()->user()->getImage() }}" class="w-100 h-100 rounded-circle img-thumbnail">
                                </label>
                                <input class="form-control img-input" type="file" name="img" accept=".png,.jpg,.jpeg,.gif">
                                <div class="invalid-feedback text-center">@lang("validation.mimes",[ "attribute"=>"","values" => "png,jpg,jpeg,gif"])</div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputPhone" class="col-sm-auto w-100px pl-0 col-form-label text-right">رقم الهاتف</label>
                            <div class="col-sm">
                                <input type="text" name="phone" id="inputPhone" class="form-control text-right" dir='ltr' value="{{ authClient()->user()->phone }}" pattern="\s*([0-9\-\+]\s*){3,14}" required>
                                <div class="invalid-feedback text-center">@lang('validation.digits_between',['attribute'=>'رقم الهاتف','min'=> 3 ,'max'=>14])</div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputAddress" class="col-sm-auto w-100px pl-0 col-form-label text-right">العنوان</label>
                            <div class="col-sm">
                                <input type="text" name="address" id="inputAddress" class="form-control" value="{{ authClient()->user()->address }}" pattern="\s*([^\s]\s*){3,64}" required>
                                <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'العنوان','min'=> 3 ,'max'=>64])</div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputReceiveIn" class="col-sm-auto w-100px pl-0 col-form-label text-right">استلام في</label>
                            <div class="col-sm">
                                <select id="inputReceiveIn" class="form-control setValue" value="{{ authClient()->user()->receive_in }}" name="receive_in" required>
                                    @foreach($receivingPlaces as $place)
                                        <option value="{{ $place->id }}">{{ $place->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback text-center">@lang('validation.required',['attribute'=>'المكان'])</div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-auto w-100px pl-0 col-form-label text-right">كلمة المرور</label>
                            <div class="col-sm">
                                <input id="inputPassword" type="password" minlength="6" maxlength="32" class="form-control" name="password" placeholder="كلمة المرور الجديدة">
                                <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'كلمة المرور','min'=> 6 ,'max'=>32])</div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-125px">تحديث</button>
                    <button type="button" class="btn btn-danger mr-2 w-75px" data-dismiss="modal">إلغاء</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--    End Modal editModal -->

@endsection
